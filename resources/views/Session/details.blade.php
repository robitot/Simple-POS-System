@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Cashier Shifts',
        'subTitle' => 'You can see cashier shift history here',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'productSize.craete',
    ])

@livewire('session.details',['id' => $id])

@endsection