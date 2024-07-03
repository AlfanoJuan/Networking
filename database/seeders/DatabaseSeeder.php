<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //Usuario adminsitrador
        \App\Models\User::create(
            [
            'email' => 'admin@example.com',
            'password' => 'adminpass123',
            'rol' => 'admin'
            ]
        );

         //Usuario empresa fake
         \App\Models\User::create(
            [
            'email' => 'coppel@net.working.com',
            'password' => 'adminpass123',
            'rol' => 'company'
            ]
        );

         //Usuario estudiante
         \App\Models\User::create(
            [
            'email' => 'ea-lecea@net.working.com',
            'password' => 'adminpass123',
            'rol' => 'student'
            ]
        );

    }
}
