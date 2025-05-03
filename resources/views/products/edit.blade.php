@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Edit Product',
        'subTitle' => '',
        'isWithBtn' => false,
    ])

    @livewire('products.edit',['productId' => $productId])

    {{-- @include('components.toast', [
        'successTitle' => 'Product created successfully',
        'errorTitle' => 'Creating product failed',
    ]) --}}

@endsection
