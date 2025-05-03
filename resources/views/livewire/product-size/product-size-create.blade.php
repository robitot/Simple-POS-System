@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'Enter the size information'])

    <form wire:submit='create' class="w-100 d-flex flex-column gap-4">

        @include('components.input', [
            'model' => 'createDrinkSize.name',
            'type' => 'text',
            'label' => 'Name',
        ])

        @include('components.input', [
            'model' => 'createDrinkSize.price',
            'type' => 'number',
            'label' => 'Price',
        ])

        <select style="padding-top:.625rem" wire:model="productId" class="form-select" aria-label="Default select example">
            <option value="">Select Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>


        <div class="d-flex justify-content-center gap-2">
            <select style="padding-top:.625rem" wire:model="inventoryId" class="form-select"
                aria-label="Default select example">
                <option value="">Select ingredients</option>
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                @endforeach
            </select>

            <select style="padding-top:.625rem" wire:model='createDrinkSize.uom' class="form-select"
                aria-label="Default select example">
                <option value="" selected>Select UOM</option>
                <option value="ML">ML</option>
            </select>

            @include('components.input', [
                'model' => 'createDrinkSize.qty',
                'type' => 'number',
                'label' => 'QTY',
            ])

            <button  wire:click.prevent='addInventory' class="btn btn-primary" style="background: #9fa1ca!important;">
                Add
            </button>

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col">action</th>
                </tr>
            </thead>
            <tbody>
                @if ($addedInventories != null)
                    @foreach ($addedInventories as $inventory)
                        <tr>
                            <td>{{ $inventory['name'] }}</td>
                            <td>{{ $inventory['quantity'] }} {{ $inventory['uom'] }}</td>
                            <td><button wire:click.prevent='remove({{ $inventory['id'] }})'
                                    class="btn btn-danger">Remove</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">No Matching Record Found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @include('components.create-btn', [
            'btnTitle' => 'Create',
        ])
    </form>
@endsection
