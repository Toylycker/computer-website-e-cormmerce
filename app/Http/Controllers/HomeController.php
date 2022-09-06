<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index()
    {
        $discount = Computer::where('discount_percent', '>', 0)
            ->where('discount_datetime_start', '<=', Carbon::now()->toDateTimeString())
            ->where('discount_datetime_end', '>=', Carbon::now()->toDateTimeString())
            ->where('stock', '>', 0)
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->inRandomOrder()
            ->take(6)
            ->get([
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ]);

        $new = Computer::where('created_at', '>=', Carbon::today()->subMonth()->toDateString())
            ->where('stock', '>', 0)
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->inRandomOrder()
            ->take(6)
            ->get([
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ]);

        $recommend = Computer::where('recommend', 1)
            ->where('stock', '>', 0)
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->inRandomOrder()
            ->take(6)
            ->get([
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ]);

        $credit = Computer::where('credit', 1)
            ->where('stock', '>', 0)
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->inRandomOrder()
            ->take(6)
            ->get([
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ]);

        $popular = Computer::where('stock', '>', 0)
            ->with(['brand:id,name', 'category:id,name_tm,name_en'])
            ->orderBy('sold', 'desc')
            ->take(6)
            ->get([
                'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
                'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at'
            ]);

        return view('home.index', [
            'discount' => $discount,
            'new' => $new,
            'recommend' => $recommend,
            'credit' => $credit,
            'popular' => $popular,
        ]);
    }


    public function about()
    {
        $page = Page::findOrFail(1);

        return view('home.about', [
            'page' => $page,
        ]);
    }


    public function contact()
    {
        $page = Page::findOrFail(2);

        return view('home.contact', [
            'page' => $page,
        ]);
    }


    public function language($key)
    {
        if ($key == 'en') {
            session()->put('locale', 'en');
        } else {
            session()->put('locale', 'tm');
        }

        return redirect()->back();
    }


    public function busket()
    {
        $cookies = explode(",", Cookie::get('store_comps'));
        $computers = Computer::WhereIn("id", $cookies)->with('brand', 'category', 'values', 'values.option')
        ->paginate(20, [
            'id', 'category_id', 'brand_id', 'name', 'slug', 'image', 'price', 'stock',
            'discount_percent', 'discount_datetime_start', 'discount_datetime_end', 'credit', 'created_at', 'model_number',
            'serial_number', 'viewed', 'stock', 'favorited'
        ], 'page')
        ->withQueryString();;



        return view("app.busket", ['computers'=>$computers,
    'busket'=>$cookies,
    'total_price' => 0
    ]);
    }

    public function send()
    {
        Cookie::queue('store_comps', "", 60 * 24);


        return redirect()->route('home')
            ->with([
                'alert'=>"zakaz alyndy. operator sizin bilen gysga wagytda habarlashar",
            ]);

    }
}
