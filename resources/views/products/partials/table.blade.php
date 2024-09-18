@foreach ($products as $item)
    <tr class="border-b">
        <td class="py-2 px-4">#{{ $item->id }}</td>
        <td class="py-2 px-4">{{ $item->name }}</td>
        <td class="py-2 px-4">{{ $item->category->name ?? 'Uncategorized' }}</td>
        <td class="py-2 px-4">{{ $item->price }}</td>
        <td class="py-2 px-4">{{ $item->quantity }}</td>

        <td class="py-2 px-4">
            @foreach ($item->attributes as $attributeItem)
                <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                    {{ $attributeItem->name }}: {{ $attributeItem->pivot?->value }}
                </span>
            @endforeach
        </td>

        <td class="py-2 px-4">
            <a href="{{ route('blade-products.edit', ['blade_product' => $item->id]) }}"
                class="text-blue-600 hover:text-blue-800">Edit</a>
            <span class="mx-2">|</span>
            <form action="{{ route('blade-products.destroy', ['blade_product' => $item->id]) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800"
                    onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
