@extends('components.container')

@section('section')

    @include('components.infor', ['title' => "Fill up the following"])

    <form wire:submit='create' class="w-100 d-flex flex-column gap-2">
        @csrf
        @include('components.input', [
            'model' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ])
        
        @include('components.create-btn', [
            'btnTitle' => 'Create',
        ])
    </form>

@endsection

  


