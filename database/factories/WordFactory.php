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
            'japanese' => $this->faker->realText(50, 2),
            'korean' => $this->faker->realText(50, 2),
            'korean_definition' => $this->faker->realText(100, 2),
            'tag' => $this->faker->randomElement(['プログラミング', 'データベース', 'OS']),
        ];
    }
}
