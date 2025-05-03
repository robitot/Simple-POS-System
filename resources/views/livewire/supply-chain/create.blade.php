@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'Enter the size information'])

    <form wire:submit='create' class="w-100 d-flex flex-column gap-4">

        <div class="mb-3 d-flex justify-content-center align-items-center w-100">
            @if ($image)
                <img wire:loading.remove src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail"
                    style="max-width: 300px; max-height: 200px;">
                <div wire:loading class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            @else
                <img wire:loading.remove
                    src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM="
                    alt="Image Preview" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                <div wire:loading class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            @endif
        </div>

        <div class="form-floating">
            <input wire:model="image" name="image" type="file" class="form-control" id="floatingInput"
                placeholder="name@example.com">
            <label for="floatingInput">Image</label> @error('image')
                <span class="text-danger fs-6">{{ $message }}</span>
            @enderror
        </div>

        @include('components.input', [
            'model' => 'inCharge',
            'type' => 'text',
            'label' => 'Name',
        ])

        @include('components.input', [
            'model' => 'amount',
            'type' => 'number',
            'label' => 'amount',
        ])


        <div class="d-flex justify-content-center gap-2">
            <select style="padding-top:.625rem" wire:model="invId" class="form-select"
                aria-label="Default select example">
                <option value="">Select ingredients</option>
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                @endforeach
            </select>

            <select style="padding-top:.625rem" wire:model='uom' class="form-select"
                aria-label="Default select example">
                <option value="" selected>Select UOM</option>
                <option value="ML">ML</option>
            </select>

            @include('components.input', [
                'model' => 'qty',
                'type' => 'number',
                'label' => 'QTY',
            ])

            <button  wire:click.prevent='add' class="btn btn-secondary">
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
