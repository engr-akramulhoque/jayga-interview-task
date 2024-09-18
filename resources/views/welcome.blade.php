@extends('layouts.layout')

@section('content')
    @if (Session::has('success'))
        <span class="w-full text-green-500 "> {{ session()->get('success') }}</span>
    @endif
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
                            <td class=" flex py-2 px-4">
                                <a href="{{ route('blade-products.edit', ['blade_product' => $item->id]) }}"
                                    class="text-blue-600 hover:text-blue-800">Edit</a>
                                <span class="mx-2">|</span>
                                <form action="{{ route('blade-products.destroy', ['blade_product' => $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
