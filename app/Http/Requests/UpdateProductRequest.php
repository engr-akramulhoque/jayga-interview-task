<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('product');

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name')->ignore($id),
            ],
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|max:255',
            'attributes' => 'required|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required|string|max:255',
        ];
    }
}
