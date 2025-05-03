@extends('components.table', [
    'data' => $expenses,
    'fileName' => 'Expenses',
])

@section('head')
    <th>Id</th>
    <th>In Charge</th>
    <th>Amount</th>
    <th>Category</th>
    <th>Status</th>
    <th>Actions</th>
@endsection

@section('body')
    @if ($expenses != null)
        @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->in_charge }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->category }}</td>
                <td>
                    @if ($expense->status == 'approved')
                        <span class="bg-success badge">{{ $expense->status }}</span>
                    @elseif($expense->status == 'rejected')
                        <span class="bg-danger badge">{{ $expense->status }}</span>
                    @elseif($expense->status == 'pending')
                        <span class="bg-warning badge">{{ $expense->status }}</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-3">
                        @if (Auth()->user()->user_role == 'admin' || Auth()->user()->user_role == 'admin_assistan')
                            @if ($expense->status == 'pending')
                                <button class="btn btn-success" wire:confirm="are you sure you want to approve this?"
                                    wire:click.prevent="approve({{ $expense->id }})">
                                    <i class="fa-solid fa-check text-white"></i>
                                </button>
                                <button class="btn btn-danger" wire:confirm="are you sure you want to reject this?"
                                    wire:click.prevent="reject({{ $expense->id }})">
                                    <i class="fa-solid fa-x text-white"></i>
                                </button>
                            @endif

                            <a class="btn btn-secondary" href="{{route('expense.view',['id' => $expense->id])}}">
                                <i class="fa-solid fa-eye text-white"></i>
                            </a>
                        @else
                            <a class="btn btn-secondary" href="{{route('expense.view',['id' => $expense->id])}}">
                                <i class="fa-solid fa-eye text-white"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
