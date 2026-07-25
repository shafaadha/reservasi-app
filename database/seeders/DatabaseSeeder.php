<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomUnit;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $hotels = Hotel::factory()->count(5)->create();

        foreach ($hotels as $hotel) {

            // Buat room
            $rooms = Room::factory()
                ->count(3)
                ->create([
                    'hotel_id' => $hotel->id,
                ]);

            // Buat room unit
            foreach ($rooms as $index => $room) {

                $floor = $index + 1;

                for ($i = 1; $i <= 10; $i++) {
                    RoomUnit::factory()->create([
                        'room_id' => $room->id,
                        'room_number' => $floor . str_pad($i, 2, '0', STR_PAD_LEFT),
                    ]);
                }
            }

            // Buat admin hotel
            User::factory()->create([
                'role' => 'admin',
                'hotel_id' => $hotel->id,
            ]);
        }

        // Buat user biasa
        User::factory(10)->create([
            'role' => 'user',
            'hotel_id' => null,
        ]);

        // Buat superadmin
        User::factory()->create([
            'role' => 'superadmin',
            'hotel_id' => null,
        ]);
    }
}
