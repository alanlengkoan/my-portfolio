<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // insert users
        $user = new User();

        $user->id_users = '1';
        $user->nama     = 'Alan Saputra Lengkoan';
        $user->email    = 'alanlengkoan@gmail.com';
        $user->roles    = 'admin';
        $user->active   = 'y';
        $user->username = 'admin';
        $user->password = '$2y$10$kYtHSUrj9tFz17XikkGqcu232LxX5ueKl6oxnKcbjr9ch9ZO48YgG';
        $user->save();
    }
}
