@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Expenses',
        'subTitle' => 'You can manage your expenses here.',
        'isWithBtn' => true,
        'btnName' => 'Create',
        'link' => 'expense.create',
    ])

@livewire('expense.expense')

@endsection