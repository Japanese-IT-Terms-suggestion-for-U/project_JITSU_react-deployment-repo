<?php

namespace Database\Factories;

use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    protected $model = Word::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'word_number' => $this->faker->unique()->numberBetween(1, 10000),
            'japanese' => $this->faker->sentence(),
            'korean' => $this->faker->sentence(),
            'korean_definition' => $this->faker->sentence(),
            'tag' => $this->faker->word(),
        ];
    }
}
