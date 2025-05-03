@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Products',
        'subTitle' => '',
        'isWithBtn' => true,
        'btnName' => 'Add new',
        'link' => 'products.create',
    ])

@livewire('products.products')

@endsection