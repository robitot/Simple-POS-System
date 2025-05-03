@extends('components.container')

@section('section')
    @include('components.infor', ['title' => 'View expense information'])

    <form wire:submit='create' class="w-100 d-flex flex-column gap-3">
        @csrf

        <h5>Status: @if ($status == 'approved')
                <span class="bg-success badge">{{ $status }}</span>
            @elseif($status == 'rejected')
                <span class="bg-danger badge">{{ $status }}</span>
            @elseif($status == 'pending')
                <span class="bg-warning badge">{{ $status }}</span>
            @endif
        </h5>

        @include('components.input', [
            'model' => 'amount',
            'type' => 'number',
            'label' => 'Amount',
        ])

        @include('components.input', [
            'model' => 'inCharge',
            'type' => 'text',
            'label' => 'In Charge',
        ])

        <select style="padding-top:.625rem" wire:model='category' class="form-select" aria-label="Default select example">
            <option value="" selected>Select Category</option>

            <option value="Rent">Rent</option>
            <option value="Utilities">Utilities</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Others">Others</option>
        </select>

        <textarea style="border:1px solid lightgray" wire:model="description" id="" rows="3" class="rounded p-2"
            placeholder="Description"></textarea>

        <div class="flex gap-3">
            @if (Auth()->user()->user_role == 'admin' || Auth()->user()->user_role == 'admin_assistan')
                @if ($status == 'pending')
                    <button class="btn btn-success" wire:confirm="are you sure you want to approve this?"
                        wire:click.prevent="approve({{ $id }})">
                        Approved
                    </button>
                    <button class="btn btn-danger" wire:confirm="are you sure you want to reject this?"
                        wire:click.prevent="reject({{ $id }})">
                        Reject
                    </button>
                @endif
            @endif
        </div>
    </form>
@endsection
