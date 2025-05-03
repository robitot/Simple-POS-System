@extends('layout.layout')

@section('content')

    @include('components.page-main-title', [
        'title' => 'Supply Chain',
        'subTitle' => 'You can manage your supply chain here',
        'isWithBtn' => true,
        'btnName' => 'Create',
        'link' => 'supplyChain.create',
    ])

@livewire('supply-chain.supply-chain')

@endsection