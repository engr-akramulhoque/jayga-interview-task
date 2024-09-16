<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(StoreProductRequest $request): Product
    {
        $product = null;

        DB::transaction(function () use ($request, &$product) {

            $product = Product::create($this->prepareValidatedData($request));

            // Ensure product was created successfully
            if (!$product) {
                throw new \Exception('Product creation failed.');
            }

            // Attach attributes if valid
            $this->attachAttributes($request['attributes'] ?? [], $product);
        });

        if ($product === null) {
            throw new \Exception('Product creation failed or no product was created.');
        }

        return $product;
    }

    /**
     * Prepare validated data with slug.
     *
     * @param StoreProductRequest $request
     * @return array
     */
    private function prepareValidatedData(StoreProductRequest $request): array
    {
        return array_merge(
            $request->validated(),
            ['slug' => str()->slug($request->name)]
        );
    }

    /**
     * Attach attributes to the product if valid.
     *
     * @param array $attributes
     * @param Product $product
     * @return void
     */
    private function attachAttributes(array $attributes, Product $product): void
    {
        if (empty($attributes)) {
            throw new \Exception('Attributes are missing or invalid.');
        }

        $attachData = [];
        foreach ($attributes as $attribute) {
            if (!isset($attribute['id'], $attribute['value'])) {
                throw new \Exception('Missing attribute ID or value.');
            }

            $attributeId = (int)$attribute['id'];

            // Validate that the attribute ID is a positive integer
            if ($attributeId <= 0) {
                throw new \Exception('Invalid attribute ID. It must be a positive integer.');
            }

            // Check if attribute value is valid
            if (empty($attribute['value'])) {
                throw new \Exception('Attribute value cannot be empty.');
            }

            $attachData[$attributeId] = ['value' => $attribute['value']];
        }

        // Attach attributes in bulk
        if (!empty($attachData)) {
            $product->attributes()->attach($attachData);
        }
    }

    public function update(UpdateProductRequest $request, Product $product): Product
    {
        // Prepare the slug from the product name
        $slug = str()->slug($request->name);

        // Update the product with validated data and slug
        $product->update(
            array_merge(
                $request->validated(),
                ['slug' => $slug]
            )
        );

        // Sync attributes (update pivot table)
        $attributes = $this->prepareAttributes($request['attributes']);

        // Sync the product attributes with the new data
        $product->attributes()->sync($attributes);

        return $product;
    }

    /**
     * Prepare and validate attributes for syncing.
     *
     * @param array $attributes
     * @return array
     * @throws \Exception
     */
    private function prepareAttributes(array $attributes): array
    {
        if (empty($attributes)) {
            return [];
        }

        $attachData = [];
        foreach ($attributes as $attribute) {
            if (!isset($attribute['id'], $attribute['value'])) {
                throw new \Exception('Missing attribute ID or value.');
            }

            // Convert attribute ID to integer
            $attributeId = (int)$attribute['id'];

            // Validate that the attribute ID is a positive integer
            if ($attributeId <= 0) {
                throw new \Exception('Invalid attribute ID. It must be a positive integer.');
            }

            // Validate that attribute value is not empty
            if (empty($attribute['value'])) {
                throw new \Exception('Attribute value cannot be empty.');
            }

            $attachData[$attributeId] = ['value' => $attribute['value']];
        }

        return $attachData;
    }
}
