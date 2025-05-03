@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Edit Drink size',
        'subTitle' => 'You can edit drink size here',
        'isWithBtn' => false,
    ])

    @livewire('product-size.product-size-edit', ['sizeId' => $sizeId])

    
    <script>
        window.addEventListener('edited-successfully', event => {
            toastr.success("Edited Successfully");
        });

        window.addEventListener('edited-qty-successfully', event => {
            toastr.success("QTY Edited Successfully");
        });

        window.addEventListener('removed-successfully', event => {
            toastr.success("Removed Successfully");
        })

        window.addEventListener('added-successfully', event => {
            toastr.success("Added Successfully");
        })

        window.addEventListener('failed-to-add', event => {
            toastr.error("Failed to add");
        })
    </script>
@endsection
