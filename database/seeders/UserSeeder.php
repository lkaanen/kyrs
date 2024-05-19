<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(1)
            ->create()
            ->each(function ($user) {
                $user->assignRole("admin");
            });

        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole("librarian");
            });

        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole("reader");
            });
    }
}
