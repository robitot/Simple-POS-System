@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Edit Inventory',
        'subTitle' => '',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'inventory.create',
    ])

    @livewire('inventory.edit-inventory', ['inventoryId' => $inventoryId])

    <script>
        window.addEventListener('sucess', event => {
            toastr.success("Edited Successfully");
        });

        window.addEventListener('store-id-is-nulld', event => {
            toastr.error("Store ID not found");
        })
    </script>
@endsection
