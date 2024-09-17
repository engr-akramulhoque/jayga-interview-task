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

            <!-- Data Table -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">All Products</h3>
                    <a href="{{ route('blade-products.create') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-800 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none">
                        Add New
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="w-full bg-gray-100 text-left">
                                <th class="py-2 px-4">ID</th>
                                <th class="py-2 px-4">Name</th>
                                <th class="py-2 px-4">Category</th>
                                <th class="py-2 px-4">Price</th>
                                <th class="py-2 px-4">Quantity</th>
                                <th class="py-2 px-4">Attributes</th>
                                <th class="py-2 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through products -->
                            @foreach ($products as $item)
                                <tr class="border-b">
                                    <td class="py-2 px-4">#{{ $item->id }}</td>
                                    <td class="py-2 px-4">{{ $item->name }}</td>
                                    <td class="py-2 px-4">{{ $item->category->name ?? 'Uncategorized' }}</td>
                                    <td class="py-2 px-4">{{ $item->price }}</td>
                                    <td class="py-2 px-4">{{ $item->quantity }}</td>

                                    <!-- Loop through attributes -->
                                    <td class="py-2 px-4">
                                        @foreach ($item->attributes as $attributeItem)
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                {{ $attributeItem->name }}: {{ $attributeItem->pivot?->value }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="py-2 px-4">
                                        <a href="#" class="text-blue-600 hover:text-blue-800">Edit</a>
                                        <span class="mx-2">|</span>
                                        <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </main>
    </div>
</body>

</html>
