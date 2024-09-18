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
                <a href="{{ route('home') }}"
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

            <!-- Main Content -->
            @yield('content')
        </main>
    </div>
</body>

</html>
