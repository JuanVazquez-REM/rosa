<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
USE Illuminate\Support\Facades\Mail;

class EnviarCorreos
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
        
            $usuario = $request->email;
            $url = $request->url();
            if($usuario && $url){ 
            EnviarCorreos::correoAviso($usuario,$url);
            return $next($request);
        }
            //$request->at($usuario,$url);
            //return $next($request);
            return abort(404,'Acceso no autorizado');
        
       
    }

    public static function correoAviso($usuario,$direccion){
        //$consultaC=DB::table('users')->select('email')
        //->where('tipo','=','admin')->get();
   
        
         $datO = array(
           'usuario'=> $usuario,
           'direccion'=>$direccion
            );
            
            
                Mail::send('modulosEm',$datO, function ($message) use ($usuario){
                    $message->from('19170074@uttcampus.edu.mx','Angel Valdez');
                    $message->to($usuario)->subject('Demo');
             
                  });
            
          
   
        
    }
}
