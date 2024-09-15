<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'price' => 10000,
                'quantity' => 10,
                'description' => 'This is a sample smartphone product.'
            ],
            [
                'category_id' => 2,
                'name' => 'T-shirts',
                'slug' => 't-shirts',
                'price' => 500,
                'quantity' => 50,
                'description' => 'This is a sample T-shirt product.'
            ],
            [
                'category_id' => 3,
                'name' => 'Refrigerators',
                'slug' => 'refrigerators',
                'price' => 30000,
                'quantity' => 5,
                'description' => 'This is a sample Refrigerator product.'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
