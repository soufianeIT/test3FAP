<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product; 
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        for ($i=0; $i < 20; $i++) {
           $product= Product::create([
                'title' => $faker->sentence(4),
                'slug' => $faker->slug,
                'subtitle' => $faker->sentence(5),
                'description' => $faker->text,
                'price' => $faker->numberBetween(15, 300) * 100,
                'image' => 'https://via.placeholder.com/200x250'
            ]);

            $categoryIds = range(1, 4);
            shuffle($categoryIds);
            $product->categories()->attach(array_slice($categoryIds, 0, 2));
        }
    }
}
