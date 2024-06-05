<?php

namespace Database\Seeders;


use App\Domain\Auth\Models\User;
use App\Domain\Tracking\Models\Tracking;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Sami',
            'last_name' => 'Maxhuni',
            'email' => 'samimaxhuni510@gmail.com',
            'password'  => 'Kosova123'
        ]);

        Tracking::factory()
            ->count(3)
            ->details()
            ->create([
                'user_id' => $user->id
            ]);
    }
}
