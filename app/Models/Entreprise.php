<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = ["nom_entreprise"];

    public function employees(){
        return $this->hasMany(Employe::class);
    }
}
