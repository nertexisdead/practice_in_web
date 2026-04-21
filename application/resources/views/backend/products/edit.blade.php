@extends('backend.layouts.app', ['title' => 'Редактирование товара'])

@section('content')
    <form method="POST" action="{{ route('admin.products.update', $product) }}">
        @csrf
        @method('PUT')
        @include('backend.products.partials.form', ['product' => $product])
    </form>
@endsection
