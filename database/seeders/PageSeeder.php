<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new Page();
        $obj->body = 'About us page';
        $obj->save();

        $obj = new Page();
        $obj->body = 'Contact page';
        $obj->save();
    }
}
