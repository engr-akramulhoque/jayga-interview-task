<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (include via CDN for simplicity) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-100">

    <!-- Sidebar -->
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar Navigation -->
        <aside class="bg-gray-800 text-white w-full md:w-64">
            <div class="h-16 flex items-center justify-center">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-10">
                <a href="#"
                    class="block py-2.5 px-4 bg-gray-700 text-white rounded hover:bg-gray-600">Products</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-100 p-8">
            <!-- Header -->
            <header class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-semibold text-gray-800">Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <input type="text" placeholder="Search" class="py-2 px-4 border rounded-lg">
                    <div class="relative">
                        <button class="text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h4l3 9h4l3-9h4"></path>
                            </svg>
                        </button>
                        <span class="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full"></span>
                    </div>
                    <div class="relative">
                        <button class="text-gray-600 focus:outline-none">
                            <svg class="w-8 h-8 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Create form -->
            <div class="bg-white rounded-lg p-6 w-full max-w-lg mx-auto shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Create New Product</h3>
                <form action="{{ route('blade-products.store') }}" method="POST" id="createProductForm">
                    @csrf

                    <!-- Category Select -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category_id" name="category_id"
                            class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01"
                            class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
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
                            class="block w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                    </div>

                    <!-- Attributes -->
                    <div id="attributesWrapper">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Attributes</h4>

                        @foreach ($existingAttributes as $attribute)
                            <div class="mb-4">
                                <!-- Checkbox for the attribute -->
                                <label class="inline-flex items-center">
                                    <input type="checkbox" id="attributeCheckbox_{{ $attribute->id }}"
                                        name="attributes[{{ $attribute->id }}][checked]" class="attribute-checkbox"
                                        data-attribute-id="{{ $attribute->id }}">
                                    <span class="ml-2 text-gray-700">{{ $attribute->name }}</span>
                                </label>

                                <!-- Hidden input field for the attribute value -->
                                <div id="attributeInputWrapper_{{ $attribute->id }}" class="mt-2 hidden">
                                    <input type="hidden" name="attributes[{{ $attribute->id }}][id]"
                                        value="{{ $attribute->id }}">
                                    <label for="attributes[{{ $attribute->id }}][value]"
                                        class="block text-sm font-medium text-gray-700">Value</label>
                                    <input type="text" id="attributes[{{ $attribute->id }}][value]"
                                        name="attributes[{{ $attribute->id }}][value]"
                                        value="{{ old('attributes.' . $attribute->id . '.value') }}"
                                        class="block w-full px-3 py-2 border rounded-md">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>


    <!-- Script to toggle input field based on checkbox status -->
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
                }
            });
        });
    </script>
</body>

</html>
