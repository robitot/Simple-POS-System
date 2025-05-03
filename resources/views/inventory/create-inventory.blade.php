@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Add new inventory',
        'subTitle' => '',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'inventory.create',
    ])

    @livewire('inventory.create-inventory')

    @include('components.toast', ['successTitle' => "Inventory created successfully", 'errorTitle' => "Creating inventory failed"])
@endsection
