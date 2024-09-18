@extends('layouts.layout')

@section('content')
    @error('errors')
        <div class="bg-red-500 px-4 py-3 rounded-lg text-sm font-bold text-white mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @enderror
    <!-- Update form -->
    <div class="bg-white rounded-lg p-6 w-full max-w-lg mx-auto shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Product</h3>
        <form action="{{ route('blade-products.update', $product->id) }}" method="POST" id="updateProductForm">
            @csrf
            @method('PUT')

            <!-- Category Select -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category_id" name="category_id"
                    class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                    class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                    step="0.01"
                    class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity -->
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                    min="1"
                    class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('quantity')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description (optional) -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description"
                    class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Attributes -->
            <div id="attributesWrapper">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Attributes</h4>

                <!-- Loop through all attributes -->
                @foreach ($attributes as $attribute)
                    <div class="mb-4">
                        <!-- Checkbox for the attribute -->
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="attributeCheckbox_{{ $attribute->id }}"
                                name="attributes[{{ $attribute->id }}][checked]" class="attribute-checkbox"
                                data-attribute-id="{{ $attribute->id }}"
                                {{ $existingAttributes->contains($attribute->id) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">{{ $attribute->name }}</span>
                        </label>

                        <!-- Hidden input field for the attribute value -->
                        <div id="attributeInputWrapper_{{ $attribute->id }}"
                            class="mt-2 {{ $existingAttributes->contains($attribute->id) ? '' : 'hidden' }}">
                            <input type="hidden" name="attributes[{{ $attribute->id }}][id]"
                                value="{{ $attribute->id }}">
                            <label for="attributes[{{ $attribute->id }}][value]"
                                class="block text-sm font-medium text-gray-700">Value</label>
                            <input type="text" id="attributes[{{ $attribute->id }}][value]"
                                name="attributes[{{ $attribute->id }}][value]"
                                value="{{ old('attributes.' . $attribute->id . '.value', $existingAttributes->find($attribute->id)->pivot->value ?? '') }}"
                                class="block w-full px-3 py-2 border rounded-md">
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Product
                </button>
            </div>
        </form>
    </div>

    <!-- Script to handle checkbox changes and form submission -->
    <script>
        document.querySelectorAll('.attribute-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var attributeId = this.getAttribute('data-attribute-id');
                var inputWrapper = document.getElementById('attributeInputWrapper_' + attributeId);

                // Show or hide the input field based on checkbox status
                if (this.checked) {
                    inputWrapper.classList.remove('hidden');
                } else {
                    inputWrapper.classList.add('hidden');
                    // Remove the attribute value when the checkbox is unchecked
                    inputWrapper.querySelectorAll('input').forEach(function(input) {
                        input.value = '';
                    });
                }
            });
        });

        // Before submitting the form, remove unchecked attributes
        document.getElementById('updateProductForm').addEventListener('submit', function(e) {
            document.querySelectorAll('.attribute-checkbox').forEach(function(checkbox) {
                var attributeId = checkbox.getAttribute('data-attribute-id');
                var inputWrapper = document.getElementById('attributeInputWrapper_' + attributeId);

                // If the checkbox is unchecked, remove the corresponding input fields
                if (!checkbox.checked) {
                    inputWrapper.querySelectorAll('input').forEach(function(input) {
                        input.remove();
                    });
                }
            });
        });
    </script>

@endsection
