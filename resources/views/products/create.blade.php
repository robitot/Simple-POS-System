@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Add new product',
        'subTitle' => '',
        'isWithBtn' => false,
    ])

    @livewire('products.create')

    @include('components.toast', [
        'successTitle' => 'Product created successfully',
        'errorTitle' => 'Creating product failed',
    ])

@endsection
