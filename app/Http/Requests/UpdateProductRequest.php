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
        $id = $this->route('products.update');

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => ['required', 'max:255', Rule::unique('products', 'name')->ignore($id)],
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'required|max:255',
        ];
    }
}
