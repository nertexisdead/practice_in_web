<div class="btn-group btn-group-sm" role="group">
    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary">Редактировать</a>
    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Удалить товар?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">Удалить</button>
    </form>
</div>
