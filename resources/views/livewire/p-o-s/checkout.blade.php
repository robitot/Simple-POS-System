<div class="d-flex gap-4 w-100 justify-content-center align-items-start">

    <style>
        @media print {
            body * {
                visibility: hidden;
                /* hide everything */
            }

            #printable-area,
            #printable-area * {
                visibility: visible;
                /* only show printable area */
            }

            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* optional: remove shadows/borders that don’t print nicely */
            .shadow-lg {
                box-shadow: none !important;
            }
        }
    </style>

    @php
        $totalAmount = collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']);
        $numericAmount = is_numeric($amount) ? (float) $amount : 0;
    @endphp

    <div class="d-flex justify-content-start gap-3 flex-column p-4 rounded shadow-lg"
        style="border:1px solid lightgray;width:300px;border: 2px solid black">
        <h5>Payment Details</h5>
        <div class="d-flex justify-content-between align-items-center w-100">
            <h6>
                Quantity:

            </h6>

            <h6>
                {{ collect($carts)->sum(fn($cart) => $cart['quantity']) }}

            </h6>
        </div>

        <div class="d-flex justify-content-between align-items-center w-100">
            <h6>
                Sub Total:
            </h6>

            <h6>
                ₱ {{ collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']) }}
            </h6>
        </div>
        @php
            $rawTotal = collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']);
            $finalTotal = $applyDiscount ? $rawTotal * 0.8 : $rawTotal;
        @endphp

        <div class="form-check">
            <input wire:model.live="applyDiscount" class="form-check-input" type="radio" id="discount" value="1">
            <label class="form-check-label" for="discount">Apply 20% Discount</label>
        </div>
        @if ($applyDiscount)
            <div class="d-flex justify-content-between align-items-center w-100">
                <h6>Discount:</h6>
                <h6> ₱ {{ number_format($rawTotal * 0.2, 2) }}</h6>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center w-100">
            <h5>
                Grand Total:
            </h5>

            <h5>
                ₱ {{ number_format($finalTotal, 2) }}
            </h5>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Table number</span>
            <input wire:model.live="tableNumber" type="number" class="form-control"
                aria-label="Amount (to the nearest dollar)" min="0">
        </div>

        <select wire:model.live="mop" class="form-select w-100" aria-label="Default select example">
            <option selected>Select Payment Method</option>
            <option value="cash">Cash</option>
            <option value="others"> <img src="{{ asset('images/GCash_Logo.png') }}" alt="menu" class="menu"
                    width="30px"> Gcash</option>
        </select>

        @if ($mop == 'cash')
            <div class="input-group mb-3">
                <span class="input-group-text">PHP</span>
                <input wire:model.live="amount" type="number" class="form-control"
                    aria-label="Amount (to the nearest dollar)" min="0">
                <span class="input-group-text">.00</span>
            </div>
        @elseif($mop == 'gcaash' || $mop == 'debit_card' || $mop == 'others')
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">#</span>
                <input wire:model.live="referenceNo" type="text" class="form-control" placeholder="Reference no."
                    aria-label="Reference No" aria-describedby="basic-addon1">
            </div>
        @endif

        @if ($mop == 'cash')
            <div class="d-flex justify-content-between align-items-center w-100">
                <h6>
                    Change:
                </h6>

                <h6>
                    ₱ {{ max(0, $numericAmount - $finalTotal) }}
                </h6>
            </div>
        @endif

        <!-- Button trigger modal -->
        <button type="button" style="background: #69dd24!important" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Place Order
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Place Order
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to proceed with the order?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" wire:click.prevent="placeOrder" @disabled(empty($mop) ||
                                ($mop === 'cash' && ($numericAmount <= 0 || $numericAmount < $totalAmount)) ||
                                (($mop === 'gcaash' || $mop === 'debit_card') && empty($referenceNo)))>
                            Yes
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-start align-items-start gap-3 flex-column shadow-lg rounded p-4 w-100"
        style="border:1px solid lightgray;border: 2px solid black;width:300px!important">
        <h5>Receipt</h5>

        <div style="border:1px solid lightgray" class="p-2 w-100" id="printable-area">
            <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                <h5 class="m-0">Jetritz</h5>
                <p>STOP AND GRILL</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                <h6 class="m-0">Receipt number: {{ $receiptNumber }}</h6>
            </div>

            @if ($carts != null)
                @foreach ($carts as $cart)
                    <div class="d-flex flex-column gap-3 w-100 mb-3"
                        style="border-bottom:1px solid black;border-top:1px solid black">

                        <div class="d-flex justify-content-start align-items-start gap-3 w-100">

                            <div class="d-flex  gap-2 justify-content-between align-items-center w-100">

                                <div>
                                    <span class="">
                                        {{ $cart['product']['name'] }}

                                    </span>

                                </div>


                                <div>
                                    <span>{{ $cart['size']['current_price'] }} x {{ $cart['quantity'] }}</span>
                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach
            @endif

            <div class="d-flex justify-content-between ">
                <p>Order Date:</p>
                <p>{{ now()->format('F j, Y') }}</p>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <p>Table Number:</p>
                <p>{{ $tableNumber }}</p>
            </div>

            <div class="d-flex justify-content-between">
                <p>
                    MOP:

                </p>

                @if ($mop)
                    <p>
                        {{ $mop == 'cash' ? 'Cash' : 'Gcash' }}
                    </p>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <p>
                    Reference no:

                </p>

                <p>
                    {{ $referenceNo }}
                </p>
            </div>

            <div class="d-flex justify-content-between">
                <p>
                    Sub Total:

                </p>

                <p>
                    PHP {{ collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']) }}
                </p>
            </div>

            @if ($applyDiscount)
                <div class="d-flex justify-content-between align-items-center w-100">
                    <p>Discount:</p>
                    <p> ₱ {{ number_format($rawTotal * 0.2, 2) }}</p>
                </div>
            @endif

            <div class="d-flex justify-content-between">
                <p>
                    Change:
                </p>

                <p>
                    PHP {{ max(0, $numericAmount - $finalTotal) }}
                </p>
            </div>

            <div class="d-flex justify-content-between">
                <p>
                    Total:
                </p>

                <p>
                    PHP {{ number_format($finalTotal, 2) }}
                </p>
            </div>

        </div>
    </div>

    <script>
        window.addEventListener('success-order', event => {
            window.print();
            window.location.href = "{{ route('POS') }}";

        });
    </script>

</div>
