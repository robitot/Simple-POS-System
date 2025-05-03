@if ($page === 1)
        <div class="d-flex justify-content-start flex-column mb-3">
            <span class="w-100 text-center text-secondary">Enter your login credentials</span>
        </div>
    @elseif($page === 2)
        <div class="d-flex justify-content-start flex-column mb-3">
            <span class="w-100 text-center text-secondary">Enter your personal information</span>
        </div>
    @elseif($page === 3)
        <div class="d-flex justify-content-start flex-column mb-3">
            <span class="w-100 text-center text-secondary">Enter your store information</span>
        </div>
    @endif