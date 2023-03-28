<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Administrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session::has('admin_session')) {
            $session = Session::get('admin_session');
            $tipo = $session['tipo'];
            if ($tipo == 'A'){
                return $next($request);
            }
            return redirect()->route('default');
        }
        return redirect()->route('login');
    }
}
