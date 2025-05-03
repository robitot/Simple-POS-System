@extends('layout.layout')

@section('content')
    @include('components.page-main-title', [
        'title' => 'Ending Shift',
        'subTitle' => 'Please enter your last cash',
        'isWithBtn' => false,
        'btnName' => 'Create',
        'link' => 'products.create',
    ])

    @livewire('p-o-s.end-session')
@endsection
