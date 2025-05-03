@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'Enter the size information'])

    <form wire:submit='edit' class="w-100 d-flex flex-column gap-4">

        @include('components.input', [
            'model' => 'productName',
            'type' => 'text',
            'label' => 'Product',
        ])

        @include('components.input', [
            'model' => 'drinkSize.name',
            'type' => 'text',
            'label' => 'Name',
        ])

        @include('components.input', [
            'model' => 'drinkSize.price',
            'type' => 'number',
            'label' => 'Price',
        ])

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">QTY</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($addedInvetories != null)
                    @foreach ($addedInvetories as $inventory)
                        <tr>
                            <td>{{ $inventory['name'] }}</td>
                            <td>
                                {{-- If in edit mode, show the input field, otherwise show the quantity --}}
                                @if ($inventory['is_editing'])
                                    <input type="number" wire:model="addedInvetories.{{ $loop->index }}.quantity"
                                        class="form-control" min="0">
                                @else
                                    {{ $inventory['quantity'] }} {{ $inventory['uom'] }}
                                @endif
                            </td>
                            <td>
                                @if ($inventory['is_editing'])
                                    <button wire:click.prevent="saveQuantity({{ $loop->index }})"
                                        class="btn btn-success">Save</button>
                                    <button id="cancel" wire:click.prevent="cancelEdit({{ $loop->index }})"
                                        class="btn btn-danger">Cancel</button>
                                @else
                                    <button wire:click.prevent="editQuantity({{ $loop->index }})"
                                        class="btn btn-primary" style="background: #9fa1ca!important">Edit</button>
                                    <button wire:click.prevent='remove({{ $inventory['id'] }})'
                                        wire:confirm="Are you sure you want to remove {{ $inventory['name'] }}?"
                                        class="btn btn-outline-danger">Remove</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">No Matching Record Found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if (!$isAddNew)

        <button class="btn btn-outline-dark border" wire:click.prevent="$set('isAddNew', true)">Add new</button>


        @else
            <div class="d-flex justify-content-center gap-2">
                <select style="padding-top:.625rem" wire:model="inventoryId" class="form-select"
                    aria-label="Default select example">
                    <option value="">Select ingredients</option>
                    @foreach ($inventories as $inventory)
                        <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                    @endforeach
                </select>

                <select style="padding-top:.625rem" wire:model='newDrink.uom' class="form-select"
                    aria-label="Default select example">
                    <option value="" selected>Select UOM</option>
                    <option value="ML">ML</option>
                </select>

                @include('components.input', [
                    'model' => 'newDrink.qty',
                    'type' => 'number',
                    'label' => 'QTY',
                ])

                <button disbaled="" wire:click.prevent='addInventory' class="btn btn-secondary">
                    Add
                </button>

            </div>

        @endif

        @include('components.create-btn', [
            'btnTitle' => 'Edit',
        ])
    </form>
@endsection
