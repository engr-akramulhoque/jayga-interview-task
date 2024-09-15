<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource(Category::find($this->category_id)),
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
        ];
    }
}
