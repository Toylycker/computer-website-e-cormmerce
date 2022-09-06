<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Value;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            ['name' => 'Screen size', 'sort_order' => 1, 'values' => [
                ['name' => '11.6"', 'sort_order' => 1],
                ['name' => '12.3"', 'sort_order' => 2],
                ['name' => '13.3"', 'sort_order' => 3],
                ['name' => '14"', 'sort_order' => 4],
                ['name' => '15.6"', 'sort_order' => 5],
                ['name' => '17.3"', 'sort_order' => 6],
            ]],
            ['name' => 'Display resolution', 'sort_order' => 2, 'values' => [
                ['name' => '1366x768', 'sort_order' => 1],
                ['name' => '1920x1080', 'sort_order' => 2],
                ['name' => '2560x1600', 'sort_order' => 3],
                ['name' => '2736x1824', 'sort_order' => 4],
            ]],
            ['name' => 'Processor', 'sort_order' => 3, 'values' => [
                ['name' => 'Apple M1', 'sort_order' => 1],
                ['name' => 'Intel Celeron', 'sort_order' => 2],
                ['name' => 'Intel Core i3', 'sort_order' => 3],
                ['name' => 'Intel Core i5', 'sort_order' => 4],
                ['name' => 'Intel Core i7', 'sort_order' => 5],
                ['name' => 'Intel Pentium', 'sort_order' => 6],
                ['name' => 'AMD RYZEN 3', 'sort_order' => 7],
                ['name' => 'AMD RYZEN 5', 'sort_order' => 8],
                ['name' => 'AMD RYZEN 7', 'sort_order' => 9],
                ['name' => 'AMD RYZEN 9', 'sort_order' => 10],
            ]],
            ['name' => 'RAM', 'sort_order' => 4, 'values' => [
                ['name' => '4 GB', 'sort_order' => 1],
                ['name' => '8 GB', 'sort_order' => 2],
                ['name' => '16 GB', 'sort_order' => 3],
            ]],
            ['name' => 'Graphics memory', 'sort_order' => 5, 'values' => [
                ['name' => '2 GB', 'sort_order' => 1],
                ['name' => '4 GB', 'sort_order' => 2],
                ['name' => '6 GB', 'sort_order' => 3],
            ]],
            ['name' => 'Storage type', 'sort_order' => 6, 'values' => [
                ['name' => 'HDD', 'sort_order' => 1],
                ['name' => 'SSD', 'sort_order' => 2],
            ]],
            ['name' => 'Storage capacity', 'sort_order' => 7, 'values' => [
                ['name' => '128 GB', 'sort_order' => 1],
                ['name' => '256 GB', 'sort_order' => 2],
                ['name' => '512 GB', 'sort_order' => 3],
                ['name' => '1 TB', 'sort_order' => 4],
            ]],
            ['name' => 'Warranty (month)', 'sort_order' => 8, 'values' => [
                ['name' => '1', 'sort_order' => 1],
                ['name' => '3', 'sort_order' => 2],
                ['name' => '6', 'sort_order' => 3],
                ['name' => '12', 'sort_order' => 4],
            ]],
        ];

        foreach ($options as $option) {
            $opt = new Option();
            $opt->name = $option['name'];
            $opt->sort_order = $option['sort_order'];
            $opt->save();

            foreach ($option['values'] as $value) {
                $val = new Value();
                $val->option_id = $opt->id;
                $val->name = $value['name'];
                $val->sort_order = $value['sort_order'];
                $val->save();
            }
        }
    }
}
