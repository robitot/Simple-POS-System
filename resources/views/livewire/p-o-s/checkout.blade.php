<div class="checkout-wrapper d-flex flex-column flex-lg-row gap-4 w-100 justify-content-center align-items-start align-items-lg-stretch">

    <style>
        .checkout-panel,
        .receipt-panel {
            border: 2px solid #000;
            border-radius: 0.75rem;
            padding: 1.5rem;
            background-color: #fff;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.08);
        }

        .checkout-panel {
            max-width: 420px;
        }

        .receipt-panel {
            flex: 1;
        }

        .receipt-items {
            width: 100%;
        }

        .receipt-item {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 0.65rem 0;
        }

        .receipt-meta {
            font-size: 0.9rem;
        }

        .receipt-header {
            text-align: center;
        }

        #printable-area {
            width: 100%;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        @media (max-width: 992px) {
            .checkout-wrapper {
                flex-direction: column;
            }

            .checkout-panel,
            .receipt-panel {
                max-width: 100%;
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printable-area,
            #printable-area * {
                visibility: visible;
            }

            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .shadow-lg {
                box-shadow: none !important;
            }
        }
    </style>

    @php
        $cartsCollection = collect($carts);
        $totalAmount = $cartsCollection->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']);
        $quantity = $cartsCollection->sum('quantity');
        $numericAmount = is_numeric($amount) ? (float) $amount : 0;
        $rawTotal = $totalAmount;
        $finalTotal = $applyDiscount ? $rawTotal * 0.8 : $rawTotal;
        $changeAmount = max(0, $numericAmount - $finalTotal);
    @endphp

    <div class="checkout-panel d-flex flex-column gap-3">
        <h5>Payment Details</h5>
        <div class="d-flex justify-content-between align-items-center w-100">
            <h6>Quantity:</h6>
            <h6>{{ $quantity }}</h6>
        </div>

        <div class="d-flex justify-content-between align-items-center w-100">
            <h6>Sub Total:</h6>
            <h6>PHP {{ number_format($totalAmount, 2) }}</h6>
        </div>

        <div class="form-check">
            <input wire:model.live="applyDiscount" class="form-check-input" type="radio" id="discount" value="1">
            <label class="form-check-label" for="discount">Apply 20% Discount</label>
        </div>

        @if ($applyDiscount)
            <div class="d-flex justify-content-between align-items-center w-100">
                <h6>Discount:</h6>
                <h6>PHP {{ number_format($rawTotal * 0.2, 2) }}</h6>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center w-100">
            <h5>Grand Total:</h5>
            <h5>PHP {{ number_format($finalTotal, 2) }}</h5>
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

        @if ($mop === 'cash')
            <div class="input-group mb-3">
                <span class="input-group-text">PHP</span>
                <input wire:model.live="amount" type="number" class="form-control"
                    aria-label="Amount (to the nearest dollar)" min="0">
                <span class="input-group-text">.00</span>
            </div>
        @elseif ($mop === 'gcaash' || $mop === 'debit_card' || $mop === 'others')
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">#</span>
                <input wire:model.live="referenceNo" type="text" class="form-control" placeholder="Reference no."
                    aria-label="Reference No" aria-describedby="basic-addon1">
            </div>
        @endif

        @if ($mop === 'cash')
            <div class="d-flex justify-content-between align-items-center w-100">
                <h6>Change:</h6>
                <h6>PHP {{ number_format($changeAmount, 2) }}</h6>
            </div>
        @endif

        <button type="button" style="background: #69dd24!important" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Place Order
        </button>

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

    <div class="receipt-panel d-flex flex-column gap-3">
        <h5>Receipt</h5>

        <div class="receipt-items shadow-sm p-3" id="printable-area">
            <div class="receipt-header mb-3">
                <h5 class="m-0">Jetritz</h5>
                <p class="m-0">STOP AND GRILL</p>
            </div>

            <div class="receipt-header mb-3">
                <h6 class="m-0">Receipt number: {{ $receiptNumber }}</h6>
            </div>

            @if (!empty($carts))
                @foreach ($carts as $cart)
                    <div class="receipt-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ $cart['product']['name'] }}</span>
                            <span>PHP {{ number_format($cart['size']['current_price'], 2) }} x {{ $cart['quantity'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between receipt-meta">
                            <span>Size: {{ $cart['size']['name'] }}</span>
                            <span>Total: PHP {{ number_format($cart['size']['current_price'] * $cart['quantity'], 2) }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-muted mb-3">No products added yet.</p>
            @endif

            <div class="d-flex justify-content-between receipt-meta">
                <p>Order Date:</p>
                <p>{{ now()->format('F j, Y') }}</p>
            </div>
            <div class="d-flex justify-content-between receipt-meta mb-3">
                <p>Table Number:</p>
                <p>{{ $tableNumber ?? 'N/A' }}</p>
            </div>
            <div class="d-flex justify-content-between receipt-meta">
                <p>MOP:</p>
                <p>
                    @if ($mop)
                        {{ $mop === 'cash' ? 'Cash' : ($mop === 'others' ? 'Gcash' : ucfirst($mop)) }}
                    @else
                        N/A
                    @endif
                </p>
            </div>

            <div class="d-flex justify-content-between receipt-meta">
                <p>Reference no:</p>
                <p>{{ $referenceNo ?? '-' }}</p>
            </div>

            <div class="d-flex justify-content-between receipt-meta">
                <p>Sub Total:</p>
                <p>PHP {{ number_format($totalAmount, 2) }}</p>
            </div>

            @if ($applyDiscount)
                <div class="d-flex justify-content-between receipt-meta">
                    <p>Discount:</p>
                    <p>PHP {{ number_format($rawTotal * 0.2, 2) }}</p>
                </div>
            @endif

            @if ($mop === 'cash')
                <div class="d-flex justify-content-between receipt-meta">
                    <p>Change:</p>
                    <p>PHP {{ number_format($changeAmount, 2) }}</p>
                </div>
            @endif

            <div class="d-flex justify-content-between receipt-meta">
                <p>Total:</p>
                <p>PHP {{ number_format($finalTotal, 2) }}</p>
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
