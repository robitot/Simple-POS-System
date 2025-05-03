@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Create Expense',
        'subTitle' => 'You can create new expense here',
        'isWithBtn' => false,
    ])

    @livewire('expense.create-expense')

    @include('components.toast', [
        'successTitle' => 'Expense created successfully',
        'errorTitle' => 'Creating expense failed',
    ])
@endsection
