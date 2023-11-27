<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(EntrepriseSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EmployeSeeder::class);
        $this->call(LogSeeder::class);
        // \App\Models\Employe::factory(10)->create();
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory(2)->create([
        //     'isAdmin' => '1',
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
