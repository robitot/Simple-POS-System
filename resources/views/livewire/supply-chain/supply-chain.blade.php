@extends('components.table', [
    'data' => $supplies,
    'fileName' => 'supplyChain',
])

@section('head')
    <th>Id</th>
    <th>In Charge</th>
    <th>Amount</th>
    <th>Status</th>
    {{-- <th>Action</th> --}}
@endsection

@section('body')
    @if ($supplies->count() != 0)
        @foreach ($supplies as $supply)
            <tr>
                <td>{{ $supply->id }}</td>
                <td>{{ $supply->in_charge }}</td>
                <td>{{ $supply->amount}}</td>
                <td class="p-3">
                    @if($supply->status == 'approved')
                        <span class="badge bg-success">Approved<span>
                    @elseif($supply->status == 'rejected')
                        <span class="badge bg-danger">Rejected<span>
                    @else
                        <span class="badge bg-warning">Pending<span>
                    @endif
                </td>
                {{-- <td>
                    
                    @if($supply->status == 'pending') 

                        <div class="d-flex gap-2">
                            <button class="btn btn-secondary">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button wire:confirm="Are you sure you want to approve this?" wire:click.prevent="approved({{$supply->id}})" class="btn btn-success">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button class="btn btn-danger" wire:click.prevent="rejected({{$supply->id}})" wire:confirm="Are you sure you want to reject this?">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                    @else
                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @endif

                </td> --}}
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
