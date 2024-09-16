<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create attributes (outside the loop)
        $color = Attribute::create(['attribute' => 'Color']);
        $size = Attribute::create(['attribute' => 'Size']);

        // Define the products array
        $products = [
            [
                'category_id' => 1,
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'This is a sample smartphone product.'
            ],
            [
                'category_id' => 2,
                'name' => 'T-shirts',
                'slug' => 't-shirts',
                'description' => 'This is a sample T-shirt product.'
            ],
            [
                'category_id' => 3,
                'name' => 'Refrigerators',
                'slug' => 'refrigerators',
                'description' => 'This is a sample Refrigerator product.'
            ],
        ];

        foreach ($products as $productData) {
            // Create product
            $product = Product::create($productData);

            // Attach attributes to the product
            $product->attributes()->attach([
                $color->id => ['value' => 'Red', 'price' => 25.00, 'quantity' => 100],
                $size->id => ['value' => 'Medium', 'price' => 30.00, 'quantity' => 50],
            ]);
        }
    }
}
