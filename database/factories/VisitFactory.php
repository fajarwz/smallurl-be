<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShortUrl;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'short_url_id' => ShortUrl::factory()->create()->id,
            'device' => $this->faker->randomElement(['Webkit', 'Android', 'iOS']),
            'browser' => $this->faker->randomElement(['Chrome', 'Firefox', 'Safari']),
        ];
    }
}
