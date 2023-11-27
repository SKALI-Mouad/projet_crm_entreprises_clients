<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employe;
use Inertia\Inertia;

class ConfirmationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if(Auth::check()){
            $user = Auth::user();
            $userEmail = $user->email;
            $user = Employe::where('email_employe', '=', $userEmail)->first();
            if ($user->is_verified == '0') {

                $defaultRoute = route("utilisateur.confirmation");
                $intended_route = redirect()->intended($defaultRoute)->getTargetUrl();
                return Inertia::location($intended_route);

            }
            return $next($request);
            // } else { 
            //     return redirect('/login');
            // }
            // else {
            //     return redirect('/entreprise');
            //     //return redirect('/logout');
            //}
            //return redirect('/');
        //} else {
        //     return redirect('/login');
        //}   
    }
}