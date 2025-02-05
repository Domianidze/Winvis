<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\Matchup;
use App\Models\Player;

class MatchupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Matchup::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'player1_score' => fake()->numberBetween(0, 5),
            'player2_score' => fake()->numberBetween(5, 10),
            'winner_id' => Player::factory(),
            'game_id' => Game::factory(),
        ];
    }
}
