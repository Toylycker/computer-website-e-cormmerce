<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            'ACER',
            'APPLE',
            'ASUS',
            'DELL',
            'FUJITSU',
            'HP',
            'LENOVO',
            'MICROSOFT',
            'MSI',
            'SAMSUNG',
            'SONY',
            'TOSHIBA',
        ];
        foreach ($brands as $brand) {
            $obj = new Brand();
            $obj->name = $brand;
            $obj->slug = Str::slug($brand);
            $obj->save();
        }
    }
}
