<?php

namespace App\Http\Middleware;

use Closure;

class AccesoAut
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
        $verificar= \App\User::where('email',$request->emial)->first();
        if($verificar){
            if($verificar->email_verified_at==NULL){
                return abort(401,"Favor de verificar su cuenta...");
            }
        }
        
        return $next($request);
    }
}
