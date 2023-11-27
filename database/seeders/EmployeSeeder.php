<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employe;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employe::create([
            "nom_employe" => "Mertz",
            "prenom_employe" => "Joan",
            "sexe_employe" => "Masculin",
            "photo_employe" => "",
            "numero_telephone_employe" => "+212661256722",
            "email_employe" => "neha.hamill@example.com",
            "is_verified" => "1",
            "is_admin" => "1",
            "user_id" => "1",
            "entreprise_id" => "1",
            "invitation_deleted"=> "0",
        ]);
        Employe::create([
            "nom_employe" => "Bruen",
            "prenom_employe" => "Angel",
            "sexe_employe" => "Feminin",
            "photo_employe" => "",
            "numero_telephone_employe" => "+212765256782",
            "email_employe" => "reyna16@example.net",
            "is_verified" => "1",
            "is_admin" => "1",
            "user_id" => "2",
            "entreprise_id" => "1",
            "invitation_deleted"=> "0",
        ]);
        Employe::create([
            "nom_employe" => "Schimmel",
            "prenom_employe" => "Keith",
            "sexe_employe" => "Masculin",
            "photo_employe" => "",
            "numero_telephone_employe" => "+212605652210",
            "email_employe" => "qbosco@example.net",
            "is_verified" => "1",
            "is_admin" => "0",
            "user_id" => "3",
            "entreprise_id" => "1",
            "invitation_deleted"=> "0",
        ]);
        Employe::create([
            "nom_employe" => "Lindgren",
            "prenom_employe" => "Laurel",
            "sexe_employe" => "Feminin",
            "photo_employe" => "",
            "numero_telephone_employe" => "0756787543",
            "email_employe" => "iullrich@example.net",
            "is_verified" => "1",
            "is_admin" => "0",
            "user_id" => "4",
            "entreprise_id" => "2",
            "invitation_deleted"=> "0",
        ]);
        Employe::create([
            "nom_employe" => "Stehr",
            "prenom_employe" => "Miles",
            "sexe_employe" => "",
            "photo_employe" => "",
            "numero_telephone_employe" => "",
            "email_employe" => "ryder03@example.org",
            "is_verified" => "0",
            "is_admin" => "0",
            "user_id" => "5",
            "entreprise_id" => "2",
            "invitation_deleted"=> "0",
        ]);
        Employe::create([
            "nom_employe" => "Hudson",
            "prenom_employe" => "Stephania",
            "sexe_employe" => "",
            "photo_employe" => "",
            "numero_telephone_employe" => "",
            "email_employe" => "garrison51@example.com",
            "is_verified" => "0",
            "is_admin" => "0",
            "user_id" => "6",
            "entreprise_id" => "3",
            "invitation_deleted"=> "0",
        ]);
        Employe::create([
            "nom_employe" => "Effertz",
            "prenom_employe" => "Clark",
            "sexe_employe" => "",
            "photo_employe" => "",
            "numero_telephone_employe" => "",
            "email_employe" => "mateo.hagenes@example.net",
            "is_verified" => "0",
            "is_admin" => "0",
            "user_id" => "7",
            "entreprise_id" => "3",
            "invitation_deleted"=> "0",
        ]);
    }
}
