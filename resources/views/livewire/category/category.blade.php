@extends('components.table', [
    'data' => $categories,
    'fileName' => 'Categories',
])

@section('head')
    <th>Id</th>
    <th>Name</th>
@endsection

@section('body')
    @if ($categories != null)
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2" class="text-center">No Matching Record Found</td>
        </tr>
    @endif
@endsection
