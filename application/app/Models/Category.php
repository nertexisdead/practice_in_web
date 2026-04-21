<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'alias',
        'name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function getCreatedAtFormatted(): ?string
    {
        return (($this->created_at)
            ? $this->created_at->format('Y-m-d H:i')
            : null
        );
    }

    public function getUpdatedAtFormatted(): ?string
    {
        return (($this->updated_at)
            ? $this->updated_at->format('Y-m-d H:i')
            : null
        );
    }
}
