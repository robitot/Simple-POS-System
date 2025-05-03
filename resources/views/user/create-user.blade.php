@extends('layout.layout')

@section('content')

    @include('components.page-main-title',[
        'title' => "Create user",
        'subTitle' => "",
        'isWithBtn' => false
    ])

    @livewire('user.create-user')
@endsection
