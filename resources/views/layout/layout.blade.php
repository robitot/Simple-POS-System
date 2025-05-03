<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>JETRITZ</title>
    {{-- custom css --}}
    <link rel="stylesheet" href="customeCss/gen.css">

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @livewireStyles
    <style>
        .bg-color {
            background-color: #FAFEF7;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -1;
        }

        .btn-primary {
            background-color: #69DD24 !important;
            color: black !important;
            border: none;
            transition: 0.3s ease-in-out;

        }

        .btn-primary:hover {
            transform: scale(1.05);
            opacity: 0.8;
        }

        .bg-secondary {
            background-color: #a0aacf !important;

        }

        .main-cont {
            padding-right: 100px;
            padding-left: 100px;
        }

        .create-cancel-btn {
            background-color: white;
            border: 1px solid red;
            color: red;
        }

        @media (max-width: 500px) {
            .main-cont {
                padding-right: 20px;
                padding-left: 20px;
            }
        }
    </style>

</head>

<body class="antialiased ">

    <div class="bg-color"></div>

    @auth
        @include('layout.nav')
    @endauth

    <section class="main-cont">
        @yield('content')
        
    </section>

  
</body>

{{-- bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>

{{-- toast --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- font icon --}}
<script src="https://kit.fontawesome.com/2058f57beb.js" crossorigin="anonymous"></script>

{{-- aos animation --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<script>
    $(document).ready(
        function() {
            toastr.options = {
                "progressBar": true,
            }
        }
    );

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    
</script>

{{-- Export to excel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

{{-- chart js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- aos animation --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

@stack('scripts')
@livewireScripts

</html>
