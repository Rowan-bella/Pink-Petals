<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rose Bouquets',
                'description' => 'Romantic rose bouquets',
            ],
            [
                'name' => 'Mixed Flowers',
                'description' => 'Colorful mixed flower bouquets',
            ],
            [
                'name' => 'Tulips',
                'description' => 'Elegant tulip flowers',
            ],
            [
                'name' => 'Flower Gifts',
                'description' => 'Flowers for special occasions',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
