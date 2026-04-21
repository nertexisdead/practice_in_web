<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $automotiveCategories = [
            'Тормозные колодки',
            'Моторные масла',
            'Воздушные фильтры',
            'Свечи зажигания',
            'Амортизаторы',
            'Ремни ГРМ',
            'Аккумуляторы',
            'Радиаторы',
            'Подшипники ступиц',
            'Сцепление',
        ];

        $name = $this->faker->unique()->randomElement($automotiveCategories);

        return [
            'parent_id' => null,
            'alias' => Str::slug($name),
            'name' => $name,
        ];
    }
}
