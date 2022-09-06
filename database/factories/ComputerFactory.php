<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Computer;
use App\Models\Option;
use App\Models\Value;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Computer>
 */
class ComputerFactory extends Factory
{
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Computer $computer) {
            //
        })->afterCreating(function (Computer $computer) {
            $name = [];
            $description = [];
            $values = [];

            $options = Option::with(['values'])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            foreach ($options as $option) {
                $value = $option->values->random();
                if (in_array($option->id, [1, 3])) {
                    $name[] = $value->name;
                }
                $description[] = $option->name . ': ' . $value->name;
                $values[$value->id] = ['sort_order' => $option->sort_order];
            }

            $computer->name = $computer->name . ': ' . implode(", ", $name);
            $computer->description = implode(", ", $description) . '.';
            $computer->update();

            $computer->values()->sync($values);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = Category::inRandomOrder()->first();
        $brand = Brand::inRandomOrder()->first();
        $modelNumber = $this->faker->cityPrefix() . '-' . rand(100, 99999);
        $name = $brand->name . ' ' . $modelNumber;
        $createdAt = $this->faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'model_number' => $modelNumber,
            'serial_number' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraph(rand(3, 5)),
            'price' => rand(10000, 100000),
            'stock' => rand(0, 10),
            'discount_percent' => rand(5, 25),
            'discount_datetime_start' => Carbon::parse($createdAt)->toDateTimeString(),
            'discount_datetime_end' => Carbon::parse($createdAt)->addWeek()->toDateTimeString(),
            'credit' => rand(1, 0),
            'recommend' => rand(1, 0),
            'sold' => rand(0, 10),
            'viewed' => rand(0, 50),
            'favorited' => rand(0, 30),
            'random' => rand(0, 999999),
            'created_at' => $createdAt,
        ];
    }
}
