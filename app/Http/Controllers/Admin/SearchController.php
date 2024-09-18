<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = $request->get('query');

        // Query products with a search on name, category, and attributes
        $products = Product::with('category', 'attributes')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orWhereHas('attributes', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('attribute_product.value', 'LIKE', '%' . $query . '%');
            })
            ->get();

        // Return the partial table view
        return view('products.partials.table', compact('products'))->render();
    }
}
