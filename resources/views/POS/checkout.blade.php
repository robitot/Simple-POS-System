@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Receipt',
        'subTitle' => 'Proceed with payment',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'products.create',
    ])

@livewire('p-o-s.checkout')

@endsection