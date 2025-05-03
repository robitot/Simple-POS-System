@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Starting Shift',
        'subTitle' => 'Please enter your starting cash shift',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'products.create',
    ])

    @livewire('p-o-s.start-session')
@endsection
