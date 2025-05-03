@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Create Drink size',
        'subTitle' => 'You can create new drink size here',
        'isWithBtn' => false,
    ])

    @livewire('product-size.product-size-create')

    @include('components.toast', [
        'successTitle' => 'Drink size created successfully',
        'errorTitle' => 'Creating drink size failed',
    ])

    <script>
        window.addEventListener('added-successfully', event => {
            toastr.success("Added Successfully");
        });

        window.addEventListener('failed-to-add', event => {
            toastr.error("Failed to add please complete the information");
        });

        // Listen for error event
        window.addEventListener('removed-successfully', event => {
            toastr.success("Removed Successfully");
        });
    </script>
@endsection
