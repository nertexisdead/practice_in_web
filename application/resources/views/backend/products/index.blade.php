@extends('backend.layouts.app', ['title' => 'Товары'])

@section('content')
    <div class="card card-success">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <h3 class="card-title mb-0">Список товаров</h3>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        Добавить товар
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <livewire:tables.admin.products-table />
        </div>
    </div>
@endsection
