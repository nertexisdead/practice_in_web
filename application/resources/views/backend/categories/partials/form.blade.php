<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Название</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $category?->name) }}"
                required
            >
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="alias">Alias</label>
            <input
                type="text"
                id="alias"
                name="alias"
                class="form-control @error('alias') is-invalid @enderror"
                value="{{ old('alias', $category?->alias) }}"
                required
            >
            @error('alias') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="parent_id">Родительская категория</label>
            <select
                id="parent_id"
                name="parent_id"
                class="form-control @error('parent_id') is-invalid @enderror"
            >
                <option value="">Без родителя</option>
                @foreach($parentCategories as $parentCategory)
                    <option value="{{ $parentCategory->id }}" @selected((int) old('parent_id', $category?->parent_id) === $parentCategory->id)>
                        {{ $parentCategory->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary float-right">Назад</a>
    </div>
</div>
