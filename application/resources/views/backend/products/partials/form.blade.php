<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Название</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $product?->name) }}"
                required
            >
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select
                id="category_id"
                name="category_id"
                class="form-control @error('category_id') is-invalid @enderror"
                required
            >
                <option value="">Выберите категорию</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('category_id', $product?->category_id) === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input
                type="number"
                step="0.01"
                min="0"
                id="price"
                name="price"
                class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', $product?->price) }}"
                required
            >
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="rating">Рейтинг</label>
            <input
                type="number"
                step="0.1"
                min="0"
                max="5"
                id="rating"
                name="rating"
                class="form-control @error('rating') is-invalid @enderror"
                value="{{ old('rating', $product?->rating) }}"
            >
            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group form-check">
            <input
                type="hidden"
                name="in_stock"
                value="0"
            >
            <input
                type="checkbox"
                id="in_stock"
                name="in_stock"
                value="1"
                class="form-check-input"
                @checked((bool) old('in_stock', $product?->in_stock ?? true))
            >
            <label for="in_stock" class="form-check-label">В наличии</label>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary float-right">Назад</a>
    </div>
</div>
