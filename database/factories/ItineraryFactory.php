<?php

namespace Database\Factories;

use App\Models\Itinerary;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItineraryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Itinerary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'category' => $this->faker->word,
            'duration' => $this->faker->numberBetween(1, 10),
            // Add other model attributes as needed for your application
        ];
    }
}
