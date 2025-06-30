@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Cashier Shifts Product Sales',
        'subTitle' => 'You can see cashier shift sale details here',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'productSize.craete',
    ])

@livewire('session.details',['id' => $id])

@endsection