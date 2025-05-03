<style>
    p {
        margin: 0px;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .icon-size {
        font-size: 15px;
        color: black;
    }

    .active-nav {
        background: #69dd24 !important;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid black;
    }

    .active-hover:hover {
        padding: 10px;
        border-radius: 5px;
        transition: all 0.2s ease-in-out;
        border: 1px solid black;
    }

    .active-hover:hover .text-hover {
        color: white !important;
        transition: all 0.2s ease-in-out;
    }

    .txt-color {
        color: white !important;
    }

    .active {
        background: white !important;
    }

    /* --- ADD THESE FOR GLASS EFFECT --- */
    .glass-bg {
        background: rgba(255, 255, 255, 0.2);
        /* light transparent white */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>

<div class="offcanvas offcanvas-start glass-bg" style="width:300px" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">

    <div class="offcanvas-header" style="padding-bottom: 0px">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column gap-4">

        <div class="d-flex justify-content-start flex-column gap-1">

            @if (Auth()->user()->user_role == 'admin')
                @include('layout.drawers.admin')
            @elseif(Auth()->user()->user_role == 'admin_assistan')
                @include('layout.drawers.admin-assistant')
            @elseif(Auth()->user()->user_role == 'wh')
                @include('layout.drawers.wh')
            @elseif(Auth()->user()->user_role == 'cashier')
                @include('layout.drawers.cashier')
            @endif

        </div>


    </div>
</div>
