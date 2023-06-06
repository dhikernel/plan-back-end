<?php

namespace Database\Factories\Domain\Product\Models;

use App\Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->randomElement([
                'Este produto é totalmente versátil',
                'Tudo para ser personalizado para comportar o que você preferir',
                'Tensão (Ex: 220v)',
            ]),
            'brand' => $this->faker->randomElement([
                'Electrolux',
                'Brastemp',
                'Fischer',
                'Samsung',
                'LG',
            ]),
        ];
    }
}
