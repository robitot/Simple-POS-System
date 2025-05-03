@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Add new category',
        'subTitle' => '',
        'isWithBtn' => false,
    ])

    @livewire('category.create-category')

    @include('components.toast', [
        'successTitle' => 'Category created successfully',
        'errorTitle' => 'Creating category failed',
    ])
    
@endsection
