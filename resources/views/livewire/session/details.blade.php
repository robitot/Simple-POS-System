@extends('components.table', [
    'data' => $orders,
    'fileName' => 'orders',
])

@section('body')
    <table class="table table-bordered" i>
        <thead>
            <tr>
                {{-- <th>Receipt number</th> --}}
                <th>Product</th>
                <th>Price</th>
                <th>QTY</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @if ($orders != null && count($orders))
                @php
                    $totalSales = $orders->sum('total_amount');
                @endphp

                @foreach ($orders as $order)
                    <tr>
                        {{-- <td>{{ $order->pos_order_id }}</td> --}}
                        <td>{{ $order->product_name }}</td>
                        <td>₱{{ number_format($order->price, 2) }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">No Matching Record Found</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <strong>Total Sales:</strong> ₱{{ number_format($totalSales ?? 0, 2) }}
    </div>

    <div class="mb-4">
        <button class="btn btn-primary mb-3" id="print-button">🖨️ Print Orders</button>

        <div id="printable-area" style="display:none">
            <h5 class="text-center">Jetritz POS</h5>
            <p class="text-center">Orders Report — {{ \Carbon\Carbon::now('Asia/Manila')->format('F d, Y h:i A') }}</p>
            <p class="text-center">Printed by — {{ Auth()->user()->name }}</p>

            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>Receipt Number</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>QTY</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders != null && count($orders))
                        @php $totalSales = $orders->sum('total_amount'); @endphp

                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->pos_order_id }}</td>
                                <td>{{ $order->product_name }}</td>
                                <td>₱{{ number_format($order->price, 2) }}</td>
                                <td>{{ $order->qty }}</td>
                                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No Matching Record Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-3">
                <strong>Total Sales:</strong> ₱{{ number_format($totalSales ?? 0, 2) }}
            </div>
        </div>

        <script>
            document.getElementById('print-button').addEventListener('click', function() {
                const printContents = document.getElementById('printable-area').innerHTML;
                const originalContents = document.body.innerHTML;

                setTimeout(function() {
                    document.body.innerHTML = printContents;

                    window.onafterprint = function() {
                        document.body.innerHTML = originalContents;
                        window.location.reload();
                    };

                    window.print();
                }, 300);
            });
        </script>
    </div>

@endsection
