<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ResponseTrait;

    private $handleProduct;

    public function __construct(ProductService $handleProduct = null)
    {
        $this->handleProduct = $handleProduct;
    }

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
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->handleProduct->create($request);

        return $product ? $this->success(new ProductResource($product), 'Product created successfully') : $this->error('Product creation failed');
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
