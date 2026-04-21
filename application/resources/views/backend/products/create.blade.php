@extends('backend.layouts.app', ['title' => 'Создание товара'])

@section('content')
    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf
        @include('backend.products.partials.form', ['product' => null])
    </form>
@endsection
