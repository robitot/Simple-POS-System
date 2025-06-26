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
                        <button class="{{ $user->is_acive ? 'btn btn-danger' : 'btn btn-success' }}" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" wire:click="$set('selectedUserId', {{ $user->id }})">
                            {{ $user->is_acive ? 'Close account' : 'Open account' }}
                        </button>

                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            wire:click="$set('userToDelete', {{ $user->id }})">
                            <i class="fa-solid fa-trash" style="color:white"></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to change the status?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click.prevent="isActive({{ $selectedUserId }})"
                        data-bs-dismiss="modal">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="deleteUser" data-bs-dismiss="modal">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
