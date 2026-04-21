<?php

namespace App\Http\Resources\Api\V1\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    public function __construct($resource, private $filters, private $orders, private $pagination)
    {
        parent::__construct($resource);
    }

    public function getCategories(): array
    {
        return $this->collection
            ->map(function ($category) {
                return new Resource($category);
            })
            ->toArray()
        ;
    }

    public function toArray(Request $request): array
    {
        return [
            ...[
                'categories' => $this->getCategories(),
            ],
            ...collect([
                'filters' => (($this->filters)
                    ? (object) $this->filters
                    : null
                ),
                'orders' => (($this->orders)
                    ? (object) $this->orders
                    : null
                ),
                'pagination' => (($this->pagination)
                    ? (object) $this->pagination
                    : null
                ),
            ])
                ->filter()
                ->all(),
        ];
    }
}
