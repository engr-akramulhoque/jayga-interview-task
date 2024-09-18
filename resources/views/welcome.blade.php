@extends('layouts.layout')

@section('content')
    @if (Session::has('success'))
        <span class="w-full text-green-500 "> {{ session()->get('success') }}</span>
    @endif

    <!-- Search Form -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex items-center mb-4">
            <input type="text" id="search" placeholder="Search products..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md">
        </div>
    </div>

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
            <table id="products-table" class="min-w-full bg-white">
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
                    <!-- Content will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchProducts(query = '') {
                $.ajax({
                    url: "{{ route('products.search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#products-table tbody').html(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });
            }

            $('#search').on('keyup', function() {
                let query = $(this).val();
                fetchProducts(query);
            });

            // Optional: Initial load
            fetchProducts();
        });
    </script>
@endsection
