@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Drink Sizes',
        'subTitle' => 'You can manage your drink sizes here',
        'isWithBtn' => true,
        'btnName' => 'Create',
        'link' => 'productSize.craete',
    ])

@livewire('productSize.product-size')

@endsection