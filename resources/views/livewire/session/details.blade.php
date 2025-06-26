@extends('components.table', [
    'data' => $orders,
    'fileName' => 'orders',
])

@section('head')
    <th>Id</th>
    <th>Product</th>
    <th>Price</th>
    <th>QTY</th>
    <th>Total Price</th>
@endsection

@section('body')
    @if ($orders != null)
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->qty }}</td>
                <td>{{ $order->total_amount }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
