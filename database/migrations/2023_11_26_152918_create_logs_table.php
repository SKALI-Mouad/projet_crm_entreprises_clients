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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            //$table->dateTime("created_at", $precision = 0);
            $table->string("nom_admin")->nullable();
            $table->string("email_admin")->nullable();
            $table->string("nom_employe");
            $table->string("email_employe");
            $table->tinyText("description");
            $table->timestamp('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
