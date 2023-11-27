<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = ["nom_employe", "prenom_employe", "sexe_employe", "numero_telephone_employe", "email_employe", "is_verified", "is_admin", "user_id","entreprise_id", "invitation_deleted"];

    public function entreprise(){
        return $this->belongsTo(Entreprise::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
