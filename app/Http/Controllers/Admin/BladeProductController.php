<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'attributes' => 'array',
            'attributes.*.id' => 'nullable|exists:attributes,id',
            'attributes.*.value' => 'nullable|string|max:255',
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']), // Generate slug if needed
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

        return redirect()->back()->with('success', 'Product and attributes saved successfully.');
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
        $categories = Category::all(['id', 'name']); // Fetch all categories
        $attributes = Attribute::all(['id', 'name']); // Fetch all attributes
        $existingAttributes = $product->attributes()->get(); // Get product's existing attributes

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'attributes' => $attributes, // Pass all attributes to the view
            'existingAttributes' => $existingAttributes, // Pass product's existing attributes
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
            'name' => 'required|string|max:255',
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

        // Update or attach attributes
        if (isset($validated['attributes'])) {
            foreach ($validated['attributes'] as $attributeData) {
                if (isset($attributeData['value']) && $attributeData['value'] !== null) {
                    // Update the attribute value if it already exists, otherwise attach
                    $product->attributes()->syncWithoutDetaching([
                        $attributeData['id'] => ['value' => $attributeData['value']],
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Product and attributes updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return to_route('home')->with("success", "Successfully deleted");
    }
}
