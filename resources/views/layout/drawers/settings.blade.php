<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column gap-4">
        <a class="d-flex justify-content-start gap-1 align-items-center cursor-pointer text-decoration-none text-black" href="{{ route('profile') }}">
            <i class="fa-regular fa-id-card icon-size"></i> 
            <p>Profile</p>
        </a>

        @livewire('auth.logout')
    </div>
</div>
