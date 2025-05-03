@extends('components.table', [
    'data' => $users,
    'fileName' => 'Users',
])

@section('head')
    <th>Id</th>
    <th>Name</th>
    <th>Address</th>
    <th>Phone no</th>
    <th>Role</th>
    <th>Active</th>
    <th>Action</th>
@endsection

@section('body')
    @if ($users != null)
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->userDetails->address ?? 'n/a' }}</td>
                <td>{{ $user->userDetails->phone ?? 'n/a' }}</td>
                <td>{{ $user->user_role }}</td>
                <td>
                    @if ($user->is_acive)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    @if (Auth()->user()->id != $user->id)
                        <button wire:click.prevent='isActive({{ $user->id }})'
                            class="{{ $user->is_acive ? 'btn btn-danger' : 'btn btn-success' }}">
                            {{ $user->is_acive ? 'Close account' : 'Open account' }}
                        </button>
                    @endif
                </td>

            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection


