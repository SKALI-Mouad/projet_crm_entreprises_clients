<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() 
    {
        Entreprise::create(["nom_entreprise" => "Maroc Telecom"]);
        Entreprise::create(["nom_entreprise" => "Orange"]);
        Entreprise::create(["nom_entreprise" => "Inwi"]);
    }
}
