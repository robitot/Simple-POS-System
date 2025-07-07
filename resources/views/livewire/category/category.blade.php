@extends('components.table', [
    'data' => $categories,
    'fileName' => 'Categories',
])

@section('head')
    <th>Id</th>
    <th>Name</th>
    <th>ACtion</th>
@endsection

@section('body')
    @if ($categories != null)
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        wire:click="$set('categoryId', {{ $category->id }})">
                        <i class="fa-solid fa-trash" style="color:white"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2" class="text-center">No Matching Record Found</td>
        </tr>
    @endif

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="deleteCategory" data-bs-dismiss="modal">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
