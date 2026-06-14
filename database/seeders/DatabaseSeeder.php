<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\RoomUnits;
use Database\Factories\RoomUnitFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            RoomSeeder::class

        ]);

        User::factory(5)->create([
            'role' => fake()->randomElement(['admin', 'user', 'manager', 'superadmin'])
        ]);


        Hotel::factory()
            ->count(5)
            ->create()
            ->each(function ($hotel) {

                Room::factory()
                    ->count(3)
                    ->create([
                        'hotel_id' => $hotel->id
                    ])
                    ->each(function ($room, $index) {

                        // lantai berdasarkan index room
                        $floor = $index + 1;

                        for ($i = 1; $i <= 10; $i++) {

                            RoomUnit::factory()->create([
                                'room_id' => $room->id,

                                'room_number' =>
                                $floor .
                                    str_pad($i, 2, '0', STR_PAD_LEFT),
                            ]);
                        }
                    });
            });
    }
}
