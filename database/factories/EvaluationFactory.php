<?php

namespace Database\Factories;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evaluation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                $user = User::factory()->create();
                return $user->id;
            },
            'shop_id' => 5,
            'grade' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->text,
            'created_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
