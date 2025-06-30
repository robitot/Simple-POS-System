@extends('components.table', [
    'data' => $orders,
    'fileName' => 'Receipts',
])

@section('head')
    <th>Receipt Number</th>
    <th>Date Ordered</th>
    <th>Total</th>
    <th>Actions</th>
@endsection

@section('body')
    @if ($orders != null)
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('F j Y') }}</td>
                <td>{{ $order->total_amount }}</td>

                <td>
                    <a href="{{ route('receipt.details', ['id' => $order->id]) }}" class="btn btn-primary">
                        View Orders
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
