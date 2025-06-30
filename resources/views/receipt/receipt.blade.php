@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Receipt Order History',
        'subTitle' => 'You can see receipt history here',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'productSize.craete',
    ])

@livewire('receipt.receipt')

@endsection