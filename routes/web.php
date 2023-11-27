<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/login", [AuthController::class, "showLogin"])
->middleware("guest")
->name("login");

Route::post("/login", [AuthController::class, "authenticate"])
->middleware("guest")
->name("login.post");

Route::get('verify/{token}', [EmployeController::class, "verify"])->name("employe.verify");


Route::group([
    "middleware" => ["auth", "isAdmin"]
    //"middleware" => "isAdmin"
], function () {

    Route::get('/', function () {
        return inertia('Home');
    })->name("home");
    
    Route::get('/contact', function () {
        return inertia('Contact');
    })->name("contact");

    Route::post('/logoutAdmin', [AuthController::class, "logout"])->name("logout.admin");
    
    Route::get('/employe', [EmployeController::class, "index"])->name("employe.index");
    Route::get('/employe/invitation', [EmployeController::class, "indexInvitation"])->name("employe.indexInvitation");
    Route::post('/employe', [EmployeController::class, "store"])->name("employe.store");
    Route::get('/employe/nouveau_employe', [EmployeController::class, "create"])->name("employe.creation");
    Route::get('/employe/modification/{employe}', [EmployeController::class, "modification"])->name("employe.modification");
    Route::post('/employe/{employe}', [EmployeController::class, "update"])->name("employe.update"); 
    Route::delete('/employe/{employe}', [EmployeController::class, "delete"])->name("employe.delete");
    Route::delete('/employe/{employe}', [EmployeController::class, "deleteInvitation"])->name("employe.deleteInvitation");

    Route::get('/utilisateur', [UtilisateurController::class, "index"])->name("utilisateur.index");
    Route::get('/utilisateur/modification/{employe}', [UtilisateurController::class, "modification"])->name("utilisateur.modification");
    Route::post('/utilisateur/{employe}', [UtilisateurController::class, "update"])->name("utilisateur.update");
    
    Route::get('/entreprise', [EntrepriseController::class, "index"])->name("entreprise.index");
    Route::get('/entreprise/modification/{entreprise}', [EntrepriseController::class, "modification"])->name("entreprise.modification");
    Route::post('/entreprise', [EntrepriseController::class, "store"])->name("entreprise.store");
    Route::put('/entreprise/{entreprise}', [EntrepriseController::class, "update"])->name("entreprise.update");
    Route::delete('/entreprise/{entreprise}', [EntrepriseController::class, "delete"])->name("entreprise.delete");

    Route::get('/activitylog', [EmployeController::class, "activityLog"])->name("employe.activityLog");

});

Route::group([
    "middleware" => ["auth", "isUser"]
], function () {

    Route::get('/utilisateur', function () {
        return inertia('IndexUtilisateur');
    })->name("homeUtilisateur");
    
    Route::get('/contact', function () {
        return inertia('Contact');
    })->name("contact");

    Route::post('/logoutUser', [AuthController::class, "logout"])->name("logout.user");

    Route::get('/utilisateur', [UtilisateurController::class, "index"])->name("utilisateur.index")->middleware("isConfirmed");
    Route::get('/utilisateur/modification/{employe}', [UtilisateurController::class, "modification"])->name("utilisateur.modification")->middleware("isConfirmed");
    Route::get('/utilisateur/confirmation', [UtilisateurController::class, "confirmation"])->name("utilisateur.confirmation");
    Route::post('/utilisateur/{employe}', [UtilisateurController::class, "update"])->name("utilisateur.update");


});