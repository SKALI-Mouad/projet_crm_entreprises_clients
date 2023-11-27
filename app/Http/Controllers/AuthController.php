<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Employe;

class AuthController extends Controller
{
    public function showLogin() {
        return Inertia::render("Login");
    }

    public function logout() {
        Auth::logout();
        return Inertia::location("/login");
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $isAdmin = $user->isAdmin;
            $id = $user->id;
            $employe = Employe::where('user_id', '=', $id)->first();
            $employeId = $employe->id;
            if ($isAdmin) {
                $defaultRoute = route("home");
            } else {
                if ($employe->is_verified) {
                    $defaultRoute = route("utilisateur.index");
                } else {
                    $defaultRoute = route("utilisateur.confirmation");
                }
                //$defaultRoute = route("utilisateur.index");
            }
            //$defaultRoute = route("home");
            $intended_route = redirect()->intended($defaultRoute)->getTargetUrl();
            return Inertia::location($intended_route);
        }  
        
        return back()->withErrors([
            'email' => "Paramètres d'authentification incorrects",
        ])->onlyInput('email');
    }
}
