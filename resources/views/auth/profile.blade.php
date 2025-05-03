@extends('layout.layout')

@section('content')
    @livewire('auth.profile')

    {{-- make this a reuseable component --}}
    <script>
        window.addEventListener('profile-edit-sucess', event => {
            toastr.success("Profile Edited Successfully");
        });

        window.addEventListener('profile-edit-failed', event => {
            toastr.error("Editing failed");
        })
    </script>
@endsection
