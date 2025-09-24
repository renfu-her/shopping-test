<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 創建根分類
        $computer = Category::create([
            'name' => 'Computer',
            'slug' => 'computer',
            'parent_id' => null,
            'description' => 'Computer and related products',
            'sort_order' => 1,
        ]);

        $communication = Category::create([
            'name' => 'Communication',
            'slug' => 'communication',
            'parent_id' => null,
            'description' => 'Communication devices and accessories',
            'sort_order' => 2,
        ]);

        // 創建 Computer 的子分類
        Category::create([
            'name' => 'Computer & Laptops',
            'slug' => 'computer-laptops',
            'parent_id' => $computer->id,
            'description' => 'Laptops and desktop computers',
            'sort_order' => 1,
        ]);

        // 創建 Communication 的子分類
        Category::create([
            'name' => 'Mobile Phones & Accessories',
            'slug' => 'mobile-phones-accessories',
            'parent_id' => $communication->id,
            'description' => 'Smartphones and mobile accessories',
            'sort_order' => 1,
        ]);
    }
}