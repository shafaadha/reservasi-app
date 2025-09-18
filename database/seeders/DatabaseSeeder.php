<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\hotel;
use App\Models\Room;
use Database\Factories\HotelFactory;
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
        Hotel::factory()
            ->count(10) // bikin 10 hotel
            ->has(Room::factory()->count(3)) // tiap hotel punya 3 room
            ->create();
    }
}
