<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if( Auth::user()->active == 0 || Auth::user()->online == 0){

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            redirect()->to('https://administracaodosistema.com.br/stores/login')->send();

        }

        return $next($request);
    }
}
