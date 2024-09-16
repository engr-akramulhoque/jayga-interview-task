<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => ProductResource::collection(Product::latest()->get()),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return $request->all();

        $slug = str()->slug($request->name);

        $product = Product::create(
            array_merge(
                $request->validated(),
                ['slug' => $slug]
            )
        );

        foreach ($request->attributes as $attribute) {
            $product->attributes()->attach($attribute['id'], ['value' => $attribute['value']]);
        }

        return response()->json([
            'status' => true,
            'data' => new ProductResource($product),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'data' => new ProductResource($product),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $slug = str()->slug($request->name);

        $product->update(
            array_merge(
                $request->validated(),
                ['slug' => $slug]
            )
        );

        // Sync attributes (update pivot table)
        $attributes = [];
        foreach ($request->attributes as $attribute) {
            $attributes[$attribute['id']] = ['value' => $attribute['value']];
        }

        // Sync the product attributes with the new data
        $product->attributes()->sync($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully.',
        ], 200);
    }
}
