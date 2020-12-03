<?php

namespace App\Http\Middleware;

use Closure;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ValidaRol
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
        if($request->user()->tokenCan('admin')){
            $usuario = $request->user()->email;
            $url = $request->url();
            ValidaRol::correo($usuario,$url);
            return abort(402,"Acceso no autorizado");
        }
        return $next($request);
    }

    public static function correo($usuario,$correo){
        $consultaMid = DB::table('users')->select('email')
        ->where('rol','=','mortal')->get();

        foreach($consultaMid as $consulta){
            $data = array(
                'usuario'=>$usuario,
                'direccion'=>$correo
            );
            $consult = DB::table('users')->select('email_verified_at')
        ->where('rol','=','mortal')->get();

        if($consult!=Null){
            Mail::send('Advertencia',$data, function($message) use ($consulta){
                $message->from('19170074@uttcampus.edu.mx','Angel Valdez');
                $message->to($consulta->email)->subject('Advertencia');

            });
        }
            
        }


    }
}
