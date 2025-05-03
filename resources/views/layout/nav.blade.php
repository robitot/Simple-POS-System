<style>
    .menu {
        transition: transform 0.3s ease;
    }

    .menu:hover {
        transform: scale(1.1);
    }
</style>

<nav class="navbar bg-body-tertiary mb-4 w-100" style="background:#69dd24!important">

    <div class="container-fluid d-flex align-items-center d-flex justify-content-between">

        <div class="d-flex align-items-center">
            <div class="p-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                <img src="{{ asset('images/hamburger.png') }}" alt="menu" class="menu" width="30px">
            </div>
            <h5 style="margin:0px" class="text-white fs-2 fw-bold">
                Jetritz
            </h5>
        </div>

        <div class="d-flex gap-3 align-items-center">
            <p class="fw-semibold">{{Auth()->user()->name}}</p>
            @livewire('auth.logout')
        </div>

    </div>

    </div>
</nav>

@include('layout.drawers.menu')
