<?php

namespace Database\Factories;

use App\Models\hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { {
            return [
                // otomatis bikin hotel baru kalau belum ada
                'hotel_id' => Hotel::factory(),
                'name' => $this->faker->randomElement([
                    'Deluxe Room',
                    'Suite Room',
                    'Standard Room',
                    'Executive Room',
                ]),
                'type' => $this->faker->randomElement(['Deluxe', 'Suite', 'Standard', 'Executive']),
                'capacity' => $this->faker->numberBetween(1, 4),
                'quantity' => $this->faker->numberBetween(1, 10),
                'price' => $this->faker->randomFloat(2, 200000, 2000000), // Rp200.000 - Rp2.000.000
                'description' => $this->faker->sentence(10),
            ];
        }
    }
}
