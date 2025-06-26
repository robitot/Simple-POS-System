@extends('components.table', [
    'data' => $products,
    'fileName' => 'products',
])

@section('head')
    <th></th>
    <th>Id</th>
    <th>Name</th>
    <th>Status</th>
    <th>Stocks</th>
    <th>Price</th>
    <th>Category</th>
    <th>Action</th>
@endsection

@section('body')
    @if ($products->count() != 0)
        @foreach ($products as $product)
            <tr>
                <td>
                    <img style="height:40px;width40px" src="{{ Storage::url($product->image) }}">
                </td>
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
                    {{ $product->sizes[0]->current_price ?? 'n/a' }}
                </td>

                <td>
                    {{ $product->category->name }}
                </td>

                <td>
                    <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-primary">
                        Edit
                    </a>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        wire:click="$set('productToDelete', {{ $product->id }})">
                        <i class="fa-solid fa-trash" style="color:white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">No Matching Record Found</td>
        </tr>
    @endif

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="deleteProduct" data-bs-dismiss="modal">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
