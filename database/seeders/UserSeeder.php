<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Joan Mertz",
            "email" => "neha.hamill@example.com",
            "isAdmin" => "1",
            "password" => "password",
            "email_verified_at" => now(),
        ]);
        User::create([
            "name" => "Angel Bruen",
            "email" => "reyna16@example.net",
            "isAdmin" => "1",
            "password" => "password",
            "email_verified_at" => now(),
        ]);
        User::create([
            "name" => "Keith Schimmel",
            "email" => "qbosco@example.net",
            "isAdmin" => "0",
            "password" => "password",
            "email_verified_at" => now(),
        ]);
        User::create([
            "name" => "Laurel Lindgren",
            "email" => "iullrich@example.net",
            "isAdmin" => "0",
            "password" => "password",
            "email_verified_at" => now(),
        ]);
        User::create([
            "name" => "Miles Stehr",
            "email" => "ryder03@example.org",
            "isAdmin" => "0",
            "password" => "password",
        ]);
        User::create([
            "name" => "Stephania Hudson",
            "email" => "garrison51@example.com",
            "isAdmin" => "0",
            "password" => "password",
        ]);
        User::create([
            "name" => "Clark Effertz",
            "email" => "mateo.hagenes@example.net",
            "isAdmin" => "0",
            "password" => "password",
        ]);
    }
}
