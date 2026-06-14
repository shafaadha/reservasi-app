<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoomUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['available'];
        $cleaningStatuses = [
            'clean',
            // 'dirty',
            // 'cleaning'
        ];
        return [
            'room_id' => Room::factory(),

            // contoh: 101, 102, 203
            'room_number' => fake()->unique()->numberBetween(100, 999),

            'status' => fake()->randomElement($statuses),

            'cleaning_status' => fake()->randomElement($cleaningStatuses),
        ];
    }
}
