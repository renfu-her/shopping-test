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

        $consumerElectronics = Category::create([
            'name' => 'Consumer Electronics',
            'slug' => 'consumer-electronics',
            'parent_id' => null,
            'description' => 'Consumer electronics and gadgets',
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

        Category::create([
            'name' => 'Desktop & Towers',
            'slug' => 'desktop-towers',
            'parent_id' => $computer->id,
            'description' => 'Desktop computers and towers',
            'sort_order' => 2,
        ]);

        // 創建 Consumer Electronics 的子分類
        Category::create([
            'name' => 'Audio & Video',
            'slug' => 'audio-video',
            'parent_id' => $consumerElectronics->id,
            'description' => 'Audio and video equipment',
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'parent_id' => $consumerElectronics->id,
            'description' => 'Smartphones and mobile devices',
            'sort_order' => 2,
        ]);

        // 創建更多子分類示例
        $laptops = Category::where('slug', 'computer-laptops')->first();
        if ($laptops) {
            Category::create([
                'name' => 'Gaming Laptops',
                'slug' => 'gaming-laptops',
                'parent_id' => $laptops->id,
                'description' => 'High-performance gaming laptops',
                'sort_order' => 1,
            ]);

            Category::create([
                'name' => 'Business Laptops',
                'slug' => 'business-laptops',
                'parent_id' => $laptops->id,
                'description' => 'Professional business laptops',
                'sort_order' => 2,
            ]);
        }
    }
}