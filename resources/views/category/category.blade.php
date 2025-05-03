@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Categories',
        'subTitle' => '',
        'isWithBtn' => true,
        'btnName' => 'Add new',
        'link' => 'category.create',
    ])

@livewire('category.category')

@endsection