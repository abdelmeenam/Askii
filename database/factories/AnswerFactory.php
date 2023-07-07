<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question_id' => fake()->numberBetween(1, 6),
            'user_id' => fake()->numberBetween(1, 3),
            'description' => $this->faker->paragraphs(3 , true),
            'best_answer' => false,
        ];
    }
}
