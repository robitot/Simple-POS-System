@extends('layout.layout')

@section('content')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            border-radius: 12px;
        }
    </style>

    <section class=" my-5 d-flex flex-column w-100 justify-content-center align-items-center gap-4" style="height: 80vh">

        <div class="p-3 rounded-3 d-flex flex-column justify-content-center gap-4 glass-effect"
            style="width:350px;border:1px solid black">

            <div class="d-flex justify-content-start flex-column">
                <h2 class="text-center fw-bold m-0" style="color:#69DD24">Jetritz</h2>
                <span class="text-center text-white">STOP AND GRILL</span>
                <hr class="text-white"/>
                <span class="text-center text-white">Please enter your log in credentials</span>
            </div>

            <form>
                @livewire('auth.login')
            </form>
        </div>

        <img src="/images/restaurant.jpg" alt="My Image" class="img-fluid"
            style="position: fixed; top: 0; right: 0; height: 100vh; width: 100%; z-index: -1; filter: brightness(50%); object-fit: cover;">

    </section>
@endsection
