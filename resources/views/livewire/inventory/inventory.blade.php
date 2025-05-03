@extends('components.table', [
    'data' => $inventories,
    'fileName' => 'Inventroies',
])

@section('head')
    <th>Id</th>
    <th>Name</th>
    <th>Quantity</th>
    <th>Action</th>
@endsection

@section('body')
    @if ($inventories != null)
        @foreach ($inventories as $inventory)
            <tr>
                <td>{{ $inventory->id }}</td>
                <td>{{ $inventory->name }}</td>
                <td>{{ $inventory->quantity }} {{ $inventory->uom }}</td>
                <td>
                    <a href="{{ route('inventory.edit', ['id' => $inventory->id]) }}" class="btn btn-primary">
                        Edit
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
