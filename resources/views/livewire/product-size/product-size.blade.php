@extends('components.table', [
    'data' => $sizes,
    'fileName' => 'drinkSize',
])

@section('head')
    <th>
        Id</th>
    <th>Size</th>
    <th>Product</th>
    <th>Action</th>
@endsection

@section('body')
    @if ($sizes->count() != 0)
        @foreach ($sizes as $size)
            <tr>
                <td>{{ $size->id }}</td>
                <td>{{ $size->name }}</td>
                <td>
                    @if ($size->product)
                        {{ $size->product->name }}
                    @else
                        <em>Product not found</em>
                    @endif
                </td>
                <td>
                    <a href="{{ route('productSize.edit', ['id' => $size->id]) }}" class="btn " data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
