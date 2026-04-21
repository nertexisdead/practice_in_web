@extends('backend.layouts.app', ['title' => 'Создание категории'])

@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        @include('backend.categories.partials.form', ['category' => null])
    </form>
@endsection
