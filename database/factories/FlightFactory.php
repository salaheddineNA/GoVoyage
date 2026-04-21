<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departingTime = $this->faker->dateTimeBetween('+1 days', '+2 months');
        $arrivingTime = $this->faker->dateTimeBetween('+1 hours', '+6 hours');
        $oldPrice = $this->faker->randomFloat(2, 3000, 6000);// Generate a random old price between 100 and 1000, with up to 2 decimal places
        $newPrice = $this->faker->optional(0.7, null)->randomFloat(2, 1500, 3000);

        return [
            'from_city' => $this->faker->city(),
            'to_city' => $this->faker->city(),
            'airline' => $this->faker->company(),
            'imageAirline' => $this->faker->imageUrl(640, 480, 'airline', true),
            'cityimg' => $this->faker->imageUrl(640, 480, 'city', true),
            'oldprice' => $oldPrice,
            'newprice' => $newPrice,
            'percentage' => $newPrice ? round((($oldPrice - $newPrice) / $oldPrice) * 100, 2) : null,// Generate a new price with the following conditions:
            'departing_time' => $departingTime,
            'arriving_time' => $arrivingTime,
            'duration' => $this->faker->numberBetween(1, 6) . 'h ' . $this->faker->numberBetween(0, 59) . 'm',
            'has_wifi' => $this->faker->boolean(80), // 80% chance to have WiFi
            'is_direct' => $this->faker->boolean(50), // 50% chance to be direct
            'is_offer' => $this->faker->boolean(30), // 30% chance to be an offer
            'showcase' => $this->faker->boolean(20), // 20% chance to showcase
        ];
    }
}
