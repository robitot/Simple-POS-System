@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Create Supply',
        'subTitle' => 'You can create new supply here',
        'isWithBtn' => false,
    ])

    @livewire('supply-chain.create')

    @include('components.toast', [
        'successTitle' => 'Supply created successfully',
        'errorTitle' => 'Creating supply failed',
    ])
    
{{-- 
    

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
    </script> --}}
@endsection
