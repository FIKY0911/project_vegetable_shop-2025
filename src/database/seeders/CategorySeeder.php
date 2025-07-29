<?php

namespace Database\Seeders;

use App\Enums\ProductCategory;
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
        $categories = [
            ProductCategory::DAUN->value,
            ProductCategory::BATANG->value,
            ProductCategory::AKAR->value,
            ProductCategory::UMBI->value,
            ProductCategory::BUAH->value,
            ProductCategory::BIJI->value,
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['is_active' => true]
            );
        }
    }
}
