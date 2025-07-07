<div class="mb-4">

    <style>
        .btn-outline-secondary.active {
            background-color: #69dd24 !important;
            color: black;
        }

        .card-style {
            border: 1px solid lightgray;
            border-bottom: 5px solid #69dd24 !important;
        }
    </style>

    <div class="w-100 d-flex justify-content-center align-items-start gap-5">

        <div class="container mb-5">

            <p>Actions:</p>
            {{-- category filter --}}
            <div class="d-flex flex-column gap-3 justify-content-start align-items-start">

                <div class="d-flex gap-3">
                    <!-- Button trigger modal -->
                    <button type="button" style="background: #69dd24!important" class="btn btn-primary"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Earnings
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        Earnings today
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Start Shift Cash: ₱ {{ $startingCash }}</h6>
                                    <h6>Cash Transaction: ₱ {{ $cash }}</h6>
                                    <h6>Gcash: ₱ {{ $eCash }}</h6>
                                    <h6>Total: ₱ {{ $totalCash }}</h6>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ route('POS.end-session') }}">End Shift</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-danger" href="{{ route('POS.end-session') }}">End Shift</a>
                </div>
                <p>Category Filter:</p>

                <div class="btn-group" style="border:1px solid black!important;border-radius:0px!important"
                    role="group" aria-label="Basic example">
                    <button type="button" style="border-radius:0px!important"
                        class="btn btn-outline-secondary {{ $currentCategoryId == 0 ? 'active' : '' }}"
                        wire:click.prevent="filterByCategory(0)">All</button>

                    @foreach ($categories as $category)
                        <button type="button" style="border-radius:0px!important"
                            class="btn btn-outline-secondary {{ $currentCategoryId == $category->id ? 'active' : '' }}"
                            wire:click.prevent="filterByCategory({{ $category->id }})">{{ $category->name }}</button>
                    @endforeach
                </div>


            </div>

            {{-- product card --}}
            <div class="row g-4 mt-3">
                @foreach ($products as $product)
                    <div class="col-md-3">

                        <div class="d-flex gap-3 flex-column p-2 rounded justify-content-center align-items-center shadow w-100"
                            style="border:2px solid black">

                            <img src="{{ Storage::url($product->image) }}" style="height:200px;width:150px"
                                class="rounded" />

                            <div class="d-flex flex-column gap-2 w-100">
                                <p class="fw-semibold fs-4 text-center">{{ $product->name }}</p>

                                <div class="d-flex gap-2  w-100 rounded w-100">
                                    @if ($product->sizes->isNotEmpty())
                                        @foreach ($product->sizes as $size)
                                            <div
                                                class="d-flex flex-column gap-2 justify-content-center align-items-center w-100">

                                                @if ($product->quantity > 10)
                                                    <button class="btn btn-primary w-100"
                                                        style="background: #69dd24!important"
                                                        wire:click.prevent="addToCart({{ $product }}, {{ $size }})"
                                                        wire:loading.class="opacity-50" wire:loading.attr="disabled">
                                                        Add to cart ({{ number_format($product->quantity, 0) }} pcs)
                                                    </button>
                                                @elseif ($product->quantity > 0 && $product->quantity <= 10)
                                                    <button class="btn btn-primary w-100"
                                                        style="background: orange!important; color:white!important"
                                                        wire:click.prevent="addToCart({{ $product }}, {{ $size }})"
                                                        wire:loading.class="opacity-50" wire:loading.attr="disabled">
                                                        Add to cart ({{ number_format($product->quantity, 0) }} pcs)
                                                    </button>
                                                @else
                                                    <button class="btn btn-primary w-100" disabled
                                                        style="background: red!important; color:white!important"
                                                        wire:click.prevent="addToCart({{ $product }}, {{ $size }})"
                                                        wire:loading.class="opacity-50" wire:loading.attr="disabled">
                                                        Out of stock
                                                    </button>
                                                @endif

                                                <span>₱ {{ $size->current_price }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <h6 class="text-center w-100" style="color:red;margin:0px">No size available
                                        </h6>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <div style="width:400px;border:2px solid black;"
            class="rounded gap-3  p-3 d-flex flex-column  rounded-lg shadow-lg">

            <h5 style="text-start w-100">Order</h5>

            @if ($carts)

                <div style="max-height: 400px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;"">
                    @foreach ($carts as $cart)
                        <div class="d-flex flex-column gap-3 p-2 rounded mb-2" style="border:2px solid black;">

                            <div class="d-flex justify-content-start align-items-start gap-3 w-100">

                                <img src="{{ Storage::url($cart['product']['image']) }}"
                                    style="height:100px;width:80px" class="rounded" />

                                <div class="d-flex flex-column gap-2 justify-content-start align-items-start">

                                    <div>
                                        <span class="fs-5 fw-semibold">
                                            {{ $cart['product']['name'] }}
                                        </span>

                                    </div>

                                    <div class="d-flex gap-2 align-items-center ">
                                        <button class="btn btn-danger btn-sm"
                                            wire:click.prevent="decrementAndIncreament(false, {{ $cart['product']['id'] }}, {{ $cart['size']['id'] }})">
                                            <i class="fa-solid fa-minus text-white"></i></button>

                                        <span>{{ $cart['quantity'] }}x</span>

                                        <button class="btn btn-success btn-sm"
                                            wire:click.prevent="decrementAndIncreament({{ true }},{{ $cart['product']['id'] }}, {{ $cart['size']['id'] }})">
                                            <i class="fa-solid fa-plus text-white"></i></button>

                                    </div>

                                    <div>
                                        <span>Price: {{ $cart['size']['current_price'] * $cart['quantity'] }}</span>
                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>
                            Quantity:

                        </h6>

                        <h6>
                            {{ collect($carts)->sum(fn($cart) => $cart['quantity']) }}

                        </h6>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <h6>
                            Total:

                        </h6>

                        <h6>
                            ₱
                            {{ collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']) }}

                        </h6>
                    </div>

                </div>

                <div class="d-flex gap-2 w-100">
                    <button class="btn btn-primary w-100" style="background: #69dd24!important"
                        wire:click.prevent="checkout">Create order</button>
                    {{-- <button class="btn btn-danger" style="white-space: nowrap" wire:click.prevent="clearCart">Clear
                        Cart</button> --}}
                </div>
            @else
                <h6 class="text-center">Order container </h6>


            @endif

        </div>

    </div>
    <x-toast-2 successTitle="Product Remove Successfully" errorTitle="Cleared successfully"
        successTrigger="product-removed-successfully" errorTrigger="cart-clear-successfully" />

    <script>
        const outOfStockTitle = @json('Out Of Stock');
        const outOfStockTrigger = @json('out-of-stock');

        window.addEventListener(outOfStockTrigger, event => {
            toastr.error(outOfStockTitle);
        });
    </script>
</div>
