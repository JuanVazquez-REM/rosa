<?php

namespace App\Http\Middleware;

use Closure;

class ValidaEdad
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
        if($request->age<=17){
            return response()->json("Acceso solo a mayores de 18+",403);
        }
        return $next($request);
    }
}
