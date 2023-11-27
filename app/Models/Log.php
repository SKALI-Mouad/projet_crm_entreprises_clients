<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = ["nom_admin", "email_admin","nom_employe", "email_employe", "description", "time"];
    public $timestamps = false;
}
