@extends('layout.layout')

@section('content')
    <section class=" my-5 d-flex flex-column w-100 justify-content-center align-items-center gap-4" style="height: 80vh">

        <div class="p-3 rounded-3 d-flex flex-column justify-content-center gap-4"
            style="background-color:white;width:350px;border:1px solid black">

            <div class="d-flex justify-content-start flex-column">
                <h2 class="text-center fw-bold m-0" style="color:#69DD24">Jetritz</h2 >
                <span class="text-center">STOP AND GRILL</span>
                <hr />
                <span class="text-center">Please enter your log in credentials</span>
            </div>

            <form>
                @livewire('auth.login')
            </form>
        </div>
    </section>
@endsection
