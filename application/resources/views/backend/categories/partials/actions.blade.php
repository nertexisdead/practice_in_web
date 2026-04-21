<div class="btn-group btn-group-sm" role="group">
    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">Редактировать</a>
    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Удалить категорию?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">Удалить</button>
    </form>
</div>
