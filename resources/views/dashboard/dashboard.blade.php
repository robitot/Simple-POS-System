@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Dashboard',
        'subTitle' => 'Sales overview today',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'expense.create',
    ])

@livewire('dashboard.dashboard')

@endsection