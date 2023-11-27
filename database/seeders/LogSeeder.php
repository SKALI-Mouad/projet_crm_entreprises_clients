<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Log;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::create([
            "nom_admin" => "Angel Bruen",
            "email_admin" => "reyna16@example.net",
            "nom_employe" => "Lindgren Laurel",
            "email_employe" => "iullrich@example.net",
            "description" => "Admin Angel Bruen a invite l'employé Lindgren Laurel à joindre la société Orange",
            "time" => now(),
        ]);
        Log::create([
            "nom_admin" => "",
            "email_admin" => "",
            "nom_employe" => "Lindgren Laurel",
            "email_employe" => "iullrich@example.net",
            "description" => "Lindgren Laurel à valider l'invitation",
            "time" => now(),
        ]);
        Log::create([
            "nom_admin" => "",
            "email_admin" => "",
            "nom_employe" => "Lindgren Laurel",
            "email_employe" => "iullrich@example.net",
            "description" => "Lindgren Laurel à confirmer son profile",
            "time" => now(),
        ]);
    }
}
