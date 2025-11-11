<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ["Salgado", "Doce", "Especial", "Bebidas"];
        foreach ($categories as $key => $category) {
            Category::query()->create(['name' => $category]);
        }
    }
}
