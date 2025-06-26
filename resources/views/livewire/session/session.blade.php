@extends('components.table', [
    'data' => $sessions,
    'fileName' => 'Sessions',
])

@section('head')
    <th>Id</th>
    <th>Shift Start Cash</th>
    {{-- <th>Cash Transaction</th>
    <th>Online Transaciton</th> --}}
    <th>Shift End Cash</th>
    <th>Status</th>
    <th>Shift Date</th>
    <th>Actions</th>

@endsection

@section('body')
    @if ($sessions != null)
        @foreach ($sessions as $session)
            <tr>
                <td>{{ $session->id }}</td>
                <td>{{ $session->starting_cash }}</td>
                {{-- <td>{{ $session->orders->where('mop', 'cash')->sum('total_amount') }}</td>
                <td>{{ $session->orders->where('mop','!=' ,'cash')->sum('total_amount') }}</td> --}}
                <td>{{ $session->ending_cash ?? 'on going' }} </td>
                <td>
                    @if ($session->status)
                        <span class="badge bg-success">Ongoing</span>
                    @else
                        <span class="badge bg-danger">Closed</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($session->created_at)->format('F j, Y') }}</td>
                                <td>
                    <a href="{{ route('session.details', ['id' => $session->id]) }}" class="btn btn-primary">
                        View
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
