@extends('layout.layout')

@section('content')

    @include('components.page-main-title',[
        'title' => "Users",
        'subTitle' => "",
        'isWithBtn' => true,
        'btnName' => "Add new",
        'link' => "user.create"
    ])

    @livewire('user.user')
@endsection
