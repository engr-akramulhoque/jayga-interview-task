<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BladeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->get(['id', 'name']);
        $attributes = Attribute::query()->get(['id', 'name']);

        return view('admin.products.create',  [
            'categories' => $categories,
            'existingAttributes' => $attributes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ]);

        // Attach attributes
        if (isset($validated['attributes'])) {
            foreach ($validated['attributes'] as $attributeData) {
                if (isset($attributeData['value']) && $attributeData['value'] !== null) {
                    $product->attributes()->attach($attributeData['id'], ['value' => $attributeData['value']]);
                }
            }
        }

        return to_route('home')->with('success', 'Product and attributes saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(['id', 'name']);
        $attributes = Attribute::all(['id', 'name']);
        $existingAttributes = $product->attributes()->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'attributes' => $attributes,
            'existingAttributes' => $existingAttributes,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name')->ignore($id),
            ],
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'attributes' => 'array',
            'attributes.*.id' => 'nullable|exists:attributes,id',
            'attributes.*.value' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Update the product's basic fields
        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']), // Optionally update the slug
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ]);

        // attach attributes
        $this->attachAttributes($product, $validated['attributes']);

        return to_route('home')->with('success', 'Product and attributes updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return to_route('home')->with("success", "Successfully deleted");
    }

    /**
     * [Description for attachAttributes]
     *
     * @param mixed $product
     * @param mixed $attributes
     * 
     * @return void
     * 
     */
    protected function attachAttributes($product, $attributes): void
    {
        $syncData = [];
        if (isset($attributes)) {
            foreach ($attributes as $attributeData) {
                if (isset($attributeData['id']) && isset($attributeData['value'])) {
                    // Prepare the data for syncing
                    $syncData[$attributeData['id']] = ['value' => $attributeData['value']];
                }
            }
        }

        // Sync the attributes with the product
        $product->attributes()->sync($syncData);
    }
}
