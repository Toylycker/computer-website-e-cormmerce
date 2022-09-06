<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name_tm' => 'Noutbuk', 'name_en' => 'Notebook', 'sort_order' => 1],
            ['name_tm' => 'Monoblok', 'name_en' => 'Monoblok', 'sort_order' => 2],
            ['name_tm' => 'Oýun', 'name_en' => 'Gaming', 'sort_order' => 3],
        ];

        foreach ($categories as $category) {
            $cat = new Category();
            $cat->name_tm = $category['name_tm'];
            $cat->name_en = $category['name_en'];
            $cat->slug = Str::slug($category['name_tm']);
            $cat->sort_order = $category['sort_order'];
            $cat->save();
        }
    }
}
