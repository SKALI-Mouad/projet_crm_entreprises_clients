<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string("nom_employe");
            $table->string("prenom_employe");
            $table->string("sexe_employe")->nullable();
            $table->string("photo_employe")->nullable();
            $table->string("numero_telephone_employe")->nullable();
            $table->string("email_employe")->unique();
            $table->boolean("is_verified")->default(0);
            $table->boolean("is_admin")->default(0);
            $table->boolean("invitation_deleted")->default(0);
            $table->integer("user_id")->default(0);
            $table->foreignId("entreprise_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(function(Blueprint $table) {
            $table->dropConstrainedForeignId("entreprise_id");
        });
        
        Schema::dropIfExists('employes');
    }
};
