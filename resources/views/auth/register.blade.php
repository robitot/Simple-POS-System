@extends('layout.layout')

@section('content')
    <section class=" my-5 d-flex flex-column w-100 justify-content-center align-items-center gap-4">

        <h2>Create Account</h2>

        <div class="p-3 rounded-3 shadow-sm d-flex flex-column justify-content-center gap-4"
            style="background-color:white;width:350px">

            <form>
                @livewire('auth.register')
            </form>
        </div>
    </section>
@endsection
