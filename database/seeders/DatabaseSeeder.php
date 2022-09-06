<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PageSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            OptionValueSeeder::class,
        ]);
        \App\Models\Computer::factory()->count(100)->create();
    }
}
