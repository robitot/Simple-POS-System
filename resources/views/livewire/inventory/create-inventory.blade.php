@extends('components.container')

@section('section')

    @include('components.infor', ['title' => "Enter the inventory information"])

    <form wire:submit='create' class="w-100 d-flex flex-column gap-2">
        @csrf
        @include('components.input', [
            'model' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ])
        
        @include('components.input', [
            'model' => 'qty',
            'type' => 'number',
            'label' => 'Quantity',
        ])

        @include('components.input', [
            'model' => 'price',
            'type' => 'number',
            'label' => 'Price',
        ])

        <select style="padding-top:.625rem" wire:model='uom' class="form-select" aria-label="Default select example">
            <option value="" selected>Select UOM</option>
            <option value="KG">KG</option>
            <option value="MG">MG</option>
            <option value="PCS">PCS</option>
            <option value="ML">ML</option>
            <option value="LITERS">LITERS</option>
        </select>

        @include('components.create-btn', [
            'btnTitle' => 'Create',
        ])
    </form>

@endsection

  


