@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Orders',
        'subTitle' => 'You can see the receipt ordered products here',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'productSize.craete',
    ])

    @livewire('receipt.details', ['id' => $id])
@endsection
