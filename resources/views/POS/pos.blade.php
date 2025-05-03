@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'POS',
        'subTitle' => 'Point of sale',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'products.create',
    ])

@livewire('p-o-s.pos')

@endsection