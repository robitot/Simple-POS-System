@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Inventory',
        'subTitle' => '',
        'isWithBtn' => true,
        'btnName' => 'Add new',
        'link' => 'inventory.create',
    ])

    @livewire('inventory.inventory')
@endsection

<script>
        window.addEventListener('sucess', event => {
            toastr.success("Edited Successfully");
        });

        window.addEventListener('store-id-is-nulld', event => {
            toastr.error("Store ID not found");
        })
    </script>