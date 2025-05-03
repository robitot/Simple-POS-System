<div class="shadow w-100 p-3 rounded d-flex justify-content-start flex-column"
    style="border:3px solid black;" wire:loading.remove>

    <h6 class="fs-5">{{ $title }}</h6>

    <div class="d-flex gap-2 align-items-center">
        <p class="fs-5">{{ number_format($data, 2) }}</p>
        {{-- <p class="fs-6"
            style="color: {{ $title === 'Expense' ? ($percentage < 0 ? 'green' : 'red') : ($percentage < 0 ? 'red' : 'green') }}">

            {{ $percentage }}%
        </p> --}}
    </div>

</div>
