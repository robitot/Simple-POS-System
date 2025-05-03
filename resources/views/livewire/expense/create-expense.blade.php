@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'Enter the expense information'])

    <form wire:submit='create'
        class="w-100 d-flex flex-column gap-3">
        @csrf
        @include('components.input', [
            'model' => 'amount',
            'type' => 'number',
            'label' => 'Amount',
        ])

        @include('components.input', [
            'model' => 'inCharge',
            'type' => 'text',
            'label' => 'In Charge',
        ])

        <select style="padding-top:.625rem"
        wire:model='category' class="form-select" aria-label="Default select example">
        <option value="" selected>Select Category</option>

        <option value="Rent">Rent</option>
        <option value="Utilities">Utilities</option>
        <option value="Maintenance">Maintenance</option>
        <option value="Others">Others</option>
        </select>

        <textarea style="border:1px solid lightgray" wire:model="description" id="" rows="3" class="rounded p-2" placeholder="Description"></textarea>

        @include('components.create-btn', [
            'btnTitle' => 'Create',
        ])
    </form>
@endsection
