<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Resources\Api\V1\Categories\Resource as CategoryResource;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'in_stock',
        'rating',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
        'rating' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryResource(): ?CategoryResource
    {
        return $this->category
            ? new CategoryResource($this->category)
            : null
        ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return (float) $this->price;
    }

    public function getPriceFormatted(): string
    {
        return number_format($this->getPrice(), 2, ',', ' ') . ' ' . "\u{20BD}";
    }

    public function getRating(): float
    {
        return (float) $this->rating;
    }

    public function getRatingPercentage(): int
    {
        return (int) round(
            min(max($this->getRating(), 0), 5) / 5 * 100
        );
    }

    public function getInStock(): bool
    {
        return (bool) $this->in_stock;
    }

    public function getStockLabel(): string
    {
        return $this->getInStock()
            ? 'В наличии'
            : 'Под заказ';
    }

    public function getSku(): string
    {
        return 'ART-' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getStorefrontDescription(): string
    {
        $categoryName = $this->category?->name ?? 'каталога';
        $availability = $this->getInStock()
            ? 'готова к быстрому заказу'
            : 'доступна под аккуратную поставку';

        return "Позиция из раздела «{$categoryName}», которая {$availability} и хорошо подходит для современной витрины интернет-магазина.";
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
