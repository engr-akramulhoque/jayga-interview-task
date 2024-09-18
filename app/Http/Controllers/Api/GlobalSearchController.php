<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $searchQuery = $request->get('query');

        // Get products matching the search query by name, category, or attributes
        $products = $this->searchProducts($searchQuery);

        // Return response 
        return $this->buildSearchResponse($products, $searchQuery);
    }

    /**
     * Search products based on the query for name, category, or attributes.
     *
     * @param string|null $searchQuery
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function searchProducts(?string $searchQuery)
    {
        return Product::with(['category', 'attributes'])
            ->where('name', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('category', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%");
            })
            ->orWhereHas('attributes', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('attribute_product.value', 'LIKE', "%{$searchQuery}%");
            })
            ->get();
    }

    /**
     * Build the JSON response for the search results.
     *
     * @param \Illuminate\Database\Eloquent\Collection $products
     * @param string|null $query
     * @return \Illuminate\Http\JsonResponse
     */
    private function buildSearchResponse($products, ?string $query)
    {
        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "No products found for the query: {$query}",
                'products' => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'products' => $products,
            'query' => $query,
        ]);
    }
}
