<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            [
                'id' => 1,
                'name' => 'Color'
            ],
            [
                'id' => 2,
                'name' => 'Size'
            ],
            [
                'id' => 3,
                'name' => 'Brand'
            ],
            [
                'id' => 4,
                'name' => 'Storage Capacity'
            ],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
