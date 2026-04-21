@extends('backend.layouts.app', ['title' => 'Категории'])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <h3 class="card-title mb-0">Список категории</h3>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        Добавить категорию
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <livewire:tables.admin.categories-table />
        </div>
    </div>
@endsection
