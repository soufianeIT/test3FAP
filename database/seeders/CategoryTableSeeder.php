<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'name' => 'recyclages',
            'slug' => 'recyclages'
        ]);

        Category::create([
            'name' => 'enlèvement de déchets',
            'slug' => 'enlèvement de déchets'
        ]);

        Category::create([
            'name' => 'matériel de recyclage',
            'slug' => 'matériel de recyclage'
        ]);

        Category::create([
            'name' => 'produits écolo',
            'slug' => 'produits écolo'
        ]);

    }
}
