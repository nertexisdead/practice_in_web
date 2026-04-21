@extends('backend.layouts.app', ['title' => 'Редактирование категории'])

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')
        @include('backend.categories.partials.form', ['category' => $category])
    </form>
@endsection
