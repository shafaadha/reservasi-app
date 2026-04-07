<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
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
            'role' =>fake()->randomElement(['admin', 'user', 'manager'])
        ]);


        Hotel::factory()
            ->count(10) //
            ->has(Room::factory()->count(3))
            ->create();
    }
}
