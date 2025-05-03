@extends('components.table', [
    'data' => $products,
    'fileName' => 'products',
])

@section('head')
    <th>Id</th>
    <th>Name</th>
    <th>Status</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Category</th>
    <th>Action</th>
@endsection

@section('body')
    @if ($products->count() != 0)
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>

                    @if ($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif

                </td>

                <td>
                    {{ $product->quantity }}
                </td>

                
                <td>
                    {{ $product->sizes[0]->current_price ?? "n/a" }}
                </td>

                <td>
                    {{ $product->category->name }}
                </td>

                <td>
                    <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-primary">
                        Edit
                    </a>

                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
