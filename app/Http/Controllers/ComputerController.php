<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Computer;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ComputerController extends Controller
{
    public function index(Request $request)
    {
         
         $request->validate([
            'q' => 'nullable|string|max:30', // search => q
            'b' => 'nullable|array', // brands => b
            'b.*' => 'nullable|integer|min:1|distinct', // brands[] => b.*
            'c' => 'nullable|array', // categories => b
            'c.*' => 'nullable|integer|min:1|distinct', // categories[] => b.*
            'v' => 'nullable|array', // values => v
            'v.*' => 'nullable|array', // values[] => v.*
            'v.*.*' => 'nullable|integer|min:1|distinct', // values[][] => v.*.*
            'd' => 'nullable|boolean', // discount => d
            'n' => 'nullable|boolean', // new => n
            't' => 'nullable|boolean', // credit => t
            's' => 'nullable|boolean', // stock => s
        ]);
        $search = $request->q ?: null;
        $f_categories = $request->has('c') ? $request->c : [];
        $f_brands = $request->has('b') ? $request->b : [];
        $f_values = $request->has('v') ? $request->v : [];
        $f_discount = $request->d ?: null;
        $f_new = $request->n ?: null;
        $f_credit = $request->t ?: null;
        $f_outOfStock = auth()->check() ? ($request->s ?: null) : null;

        // FILTER
        $categories = Category::orderBy('sort_order')
            ->orderBy('slug')
            ->get();
        $brands = Brand::orderBy('slug')
            ->get();
        $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $computers = Computer::when(isset($f_outOfStock), function ($query) {
            return $query->where('stock', '<=', 0); // if isset $f_outOfStock 
        }, 
        
        function ($query) {    //if is not isset $f_outOfStock. Tipo else 
            return $query->where('stock', '>', 0);
        })


            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->orWhere('name', 'like', '%' . $search . '%');
                    $query->orWhere('slug', 'like', '%' . $search . '%');
                    $query->orWhere('model_number', 'like', '%' . $search . '%');
                    $query->orWhere('serial_number', 'like', '%' . $search . '%');
                    $query->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when($f_categories, function ($query, $f_categories) {
                return $query->whereIn('category_id', $f_categories);
            })
            ->when($f_brands, function ($query, $f_brands) {
                return $query->whereIn('brand_id', $f_brands);
            })
            ->when($f_values, function ($query, $f_values) {
                return $query->where(function ($query1) use ($f_values) {
                    foreach ($f_values as $f_value) {
                        $query1->whereHas('values', function ($query2) use ($f_value) {
                            $query2->whereIn('id', $f_value);
                        });
                    }
                });
            })
            ->when(isset($f_discount), function ($query) {
                return $query->where('discount_percent', '>', 0)
                    ->where('discount_datetime_start', '<=', Carbon::now()->toDateTimeString())
                    ->where('discount_datetime_end', '>=', Carbon::now()->toDateTimeString());
            })
            ->when(isset($f_new), function ($query) {
                return $query->where('created_at', '>', Carbon::now()->subMonth()->toDateTimeString());
            })
            ->when(isset($f_credit), function ($query, $f_credit) {
                return $query->where('credit', $f_credit);
            })
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->orderBy('random')
            ->orderBy('id', 'desc')
            ->paginate(20, [
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ], 'page')
            ->withQueryString();

        return view('computer.index', [
            'search' => $request->q,
            'computers' => $computers,
            'categories' => $categories,
            'brands' => $brands,
            'options' => $options,
            'f_categories' => collect($f_categories),
            'f_brands' => collect($f_brands),
            'f_values' => collect($f_values)->collapse(),
            'f_discount' => $f_discount,
            'f_new' => $f_new,
            'f_credit' => $f_credit,
            'f_outOfStock' => $f_outOfStock,
        ]);
    }


    public function show($slug)
    {
        $computer = Computer::where('slug', $slug)
            ->with(['brand', 'values.option'])
            ->firstOrFail();
//        $computer = Computer::with(['brand', 'values.option'])
//            ->findOrFail($id);

        if (Cookie::has('store_views')) {
            $cookies = explode(",", Cookie::get('store_views'));
            if (!in_array($computer->id, $cookies)) {
                $computer->increment('viewed');
                $cookies[] = $computer->id;
                Cookie::queue('store_views', implode(",", $cookies), 60 * 24);
            }
        } else {
            $computer->increment('viewed');
            Cookie::queue('store_views', $computer->id, 60 * 24);
        }

        $similar = Computer::where('id', '!=', $computer->id)
            ->where('brand_id', $computer->brand_id)
            ->where('stock', '>', 0)
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->inRandomOrder()
            ->take(6)
            ->get([
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ]);

        return view('computer.show', [
            'computer' => $computer,
            'similar' => $similar,
        ]);
    }


    public function create()
    {
        $categories = Category::orderBy('sort_order')
            ->orderBy('slug')
            ->get();
        $brands = Brand::orderBy('slug')
            ->get();
        $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('computer.create', [
            'categories' => $categories,
            'brands' => $brands,
            'options' => $options,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'model_number' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:computers',
            'description' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount_percent' => 'required|integer|min:0',
            'discount_datetime_start' => 'required|date',
            'discount_datetime_end' => 'required|date',
            'credit' => 'nullable|boolean',
            'recommend' => 'nullable|boolean',
            'values_id' => 'required|array',
            'values_id.*' => 'required|integer|min:1|distinct',
            'image' => 'nullable|image|mimes:jpg,png|dimensions:min_width=500,min_height=500|max:1024',
        ]);
        // name
        $category = Category::findOrFail($request->category_id);
        $brand = Brand::findOrFail($request->brand_id);
        $name = $brand->name . ' ' . $request->model_number;

        // computer
        $computer = new Computer();
        $computer->category_id = $category->id;
        $computer->brand_id = $brand->id;
        $computer->name = $name;
        $computer->slug = Str::random(10);
        $computer->model_number = $request->model_number;
        $computer->serial_number = $request->serial_number;
        $computer->description = $request->description ?: null;
        $computer->price = $request->price;
        $computer->stock = $request->stock;
        $computer->discount_percent = $request->discount_percent;
        $computer->discount_datetime_start = Carbon::parse($request->discount_datetime_start)->toDateTimeString();
        $computer->discount_datetime_end = Carbon::parse($request->discount_datetime_end)->toDateTimeString();
        $computer->credit = $request->credit ?: 0;
        $computer->recommend = $request->recommend ?: 0;
        $computer->save();
        // slug
        $computer->slug = Str::slug($name) . '-' . $computer->id;
        $computer->update();

        $computer->values()->sync($request->values_id);

        $success = trans('app.store-response', ['name' => $computer->name]);
        return redirect()->route('computer', $computer->slug)
            ->with([
                'success' => $success,
            ]);
    }


    public function edit($slug)
    {
        $computer = Computer::where('slug', $slug)
            ->with(['values:id'])
            ->firstOrFail();
        $categories = Category::orderBy('sort_order')
            ->orderBy('slug')
            ->get();
        $brands = Brand::orderBy('slug')
            ->get();
        $options = Option::with(['values'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('computer.edit', [
            'computer' => $computer,
            'categories' => $categories,
            'brands' => $brands,
            'options' => $options,
        ]);
    }


    public function update(Request $request, $slug)
    {
        $computer = Computer::where('slug', $slug)
            ->firstOrFail();
        $request->validate([
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'model_number' => 'required|string|max:255',
            'serial_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('computers')->ignore($computer->id)
            ],
            'description' => 'nullable|string|max:2550',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount_percent' => 'required|integer|min:0',
            'discount_datetime_start' => 'required|date',
            'discount_datetime_end' => 'required|date',
            'credit' => 'nullable|boolean',
            'recommend' => 'nullable|boolean',
            'values_id' => 'required|array',
            'values_id.*' => 'required|integer|min:1|distinct',
            'image' => 'nullable|image|mimes:jpg,png|dimensions:min_width=500,min_height=500|max:1024',
        ]);

        // name
        $category = Category::findOrFail($request->category_id);
        $brand = Brand::findOrFail($request->brand_id);
        $name = $brand->name . ' ' . $request->model_number;

        // computer
        $computer->category_id = $category->id;
        $computer->brand_id = $brand->id;
        $computer->name = $name;
        $computer->slug = Str::slug($name) . '-' . $computer->id;
        $computer->model_number = $request->model_number;
        $computer->serial_number = $request->serial_number;
        $computer->description = $request->description ?: null;
        $computer->price = $request->price;
        $computer->stock = $request->stock;
        $computer->discount_percent = $request->discount_percent;
        $computer->discount_datetime_start = Carbon::parse($request->discount_datetime_start)->toDateTimeString();
        $computer->discount_datetime_end = Carbon::parse($request->discount_datetime_end)->toDateTimeString();
        $computer->credit = $request->credit ?: 0;
        $computer->recommend = $request->recommend ?: 0;
        $computer->update();

        $computer->values()->sync($request->values_id);

        // image
        if ($request->has('image')) {
            if ($computer->image) {
                Storage::delete($computer->image);
            }
            $newImage = $request->file('image');
            $newImageName = Str::random(10) . '-' . $computer->id . '.' . $newImage->getClientOriginalExtension();
            Storage::putFileAs('public/computers/', $newImage, $newImageName);
//            $newImage->storeAs('public/computers/', $newImageName);

            $computer->image = $newImageName;
            $computer->update();
        }

        $success = trans('app.update-response', ['name' => $computer->name]);
        return redirect()->route('computer', $computer->slug)
            ->with([
                'success' => $success,
            ]);
    }


    public function delete($slug)
    {
        $computer = Computer::where('slug', $slug)
            ->firstOrFail();
        $success = trans('app.delete-response', ['name' => $computer->name]);
        $computer->delete();

        return redirect()->route('computers')
            ->with([
                'success' => $success,
            ]);
    }


    public function favorite($slug)
    {
        $computer = Computer::where('slug', $slug)
            ->firstOrFail();

        if (Cookie::has('store_favorites')) {
            $cookies = explode(",", Cookie::get('store_favorites'));
            if (in_array($computer->id, $cookies)) {
                $computer->decrement('favorited');
                $index = array_search($computer->id, $cookies);
                unset($cookies[$index]);
            } else {
                $computer->increment('favorited');
                $cookies[] = $computer->id;
            }
            Cookie::queue('store_favorites', implode(",", $cookies), 60 * 24);
        } else {
            $computer->increment('favorited');
            Cookie::queue('store_favorites', $computer->id, 60 * 24);
        }

        return redirect()->back();
    }

    public function busket($slug) // here in request should be slug key for slug and order key for defining whether to add into busket or delete
    {
        $computer = Computer::where('slug', $slug)
            ->firstOrFail();
        $busket = [];

        if (Cookie::has('store_comps')) {
                        $cookies = explode(",", Cookie::get('store_comps'));
                        if (in_array($computer->id, $cookies)) {
                            $index = array_search($computer->id, $cookies);
                            unset($cookies[$index]);
                        } else {
                            $cookies[] = $computer->id;
                        }
            Cookie::queue('store_comps', implode(",", $cookies), 60 * 24);
            // $busket = explode(",", Cookie::get('store_comps'));
        } else {
            Cookie::queue('store_comps', $computer->id, 60 * 24);
            // $busket = explode(",", Cookie::get('store_comps'));
        }

        return redirect()->back();
    }
}
