<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if(Auth::check()){
            if (Auth::user()->isAdmin) {
                return $next($request);
            } 
            return redirect()->back();
            //else { 
            //     return redirect('/login');
            // }
            // else {
            //     return redirect('/entreprise');
            //     //return redirect('/logout');
            // }
            //return redirect('/');
        //} else { 
        //    return redirect('/login');
        //}
        
    }
}
