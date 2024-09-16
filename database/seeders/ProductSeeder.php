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
        $color = Attribute::find(1);
        $size = Attribute::find(2);

        // Define the products array
        $products = [
            [
                'category_id' => 1,
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'price' => 20000,
                'quantity' => 10,
                'description' => 'This is a sample smartphone product.'
            ],
            [
                'category_id' => 2,
                'name' => 'T-shirts',
                'slug' => 't-shirts',
                'price' => 200,
                'quantity' => 40,
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

        foreach ($products as $productData) {
            // Create product
            $product = Product::create($productData);

            // Attach attributes to the product
            $product->attributes()->attach([
                $color->id => ['value' => 'Red'],
                $size->id => ['value' => 'Medium'],
            ]);
        }
    }
}
