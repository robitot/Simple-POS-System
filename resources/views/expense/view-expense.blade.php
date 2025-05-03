@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'View Expense',
        'subTitle' => 'You can view expense information here',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'inventory.create',
    ])

    @livewire('expense.view-expense', ['expenseId' => $expenseId])

    <script>
        // window.addEventListener('sucess', event => {
        //     toastr.success("Approved Successfully");
        // });

        window.addEventListener('store-id-is-nulld', event => {
            toastr.error("Expense not found");
        })
    </script>
@endsection
