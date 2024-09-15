<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $slug = str()->slug($request->name);

        $product = Product::create(
            array_merge(
                $request->validated(),
                ['slug' => $slug]
            )
        );

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

        $product = $product->update(
            array_merge(
                $request->validated(),
                ['slug' => $slug]
            )
        );

        return response()->json([
            'status' => true,
            'data' => $product != null ? new ProductResource($product) : null,
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
