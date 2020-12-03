<?php

namespace App\Http\Controllers;

use App\Documento;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller
{

    public function mostrarUser(){
        $iser = User::all();
        return response()->json($iser,200);
    }


    public function regUser(Request $request){
        
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        
        $datoUser = new User;

        $datoUser->rol=$request->rol;
        $datoUser->email=$request->email;
        $datoUser->password=Hash::make($request->password);
      
        if($datoUser->save()){

            $data = array(
                'correo'=>$request->email
            );

            Mail::send('Bienvenida',$data,function ($message) use ($request){
                $message->from('19170074@uttcampus.edu.mx','Angel Valdez');
                $message->to($request->email)->subject('Señal');
            });
            return response()->json("Verifica tu cuenta",201);

        }
        return abort(400,"Error...");

      }

    public function verificar(string $correo){
        $usuario = User::where('email',$correo)->first();
        if($usuario){
          $usuario->email_verified_at = now();
          $usuario->save();
          return response()->json(["Verificacion realizada"=>$usuario]);
        }
        return abort('no autorizado',404);
      }




    public function loguinOn(Request $request){
        $request->validate([
          'email'=>'required|email',
          'password'=>'required'
        ]);

      $usuario = User::where('email', $request->email)->first();

      if(! $usuario || ! Hash::check($request->password,$usuario->password))
      {
          throw ValidationException::withMessages([
              'email' => ['Datos Incorrectos']
          ]);
      }
      if($usuario->rol=="mortal"){
          $token = $usuario->createToken($request->email,['mortal'])->plainTextToken;
         // $usuario->
         $data=array(
          'url'=>'http://127.0.0.1:8000/api/login'
        );
  
        Mail::send('recuperar',$data,function ($message) use ($usuario){
          $message->from('19170074@uttcampus.edu.mx','Angel Valdez');
          $message->to($usuario->email)->subject('Señal');
      });
      }
        return $token;

      
    }


    public function logueo(Request $request){

      $request->validate([
        'email'=>'required|email',
        'password'=>'required'
      ]);

    $usuario = User::where('email', $request->email)->first();

    if(! $usuario || ! Hash::check($request->password,$usuario->password))
    {
        throw ValidationException::withMessages([
            'email' => ['Datos Incorrectos']
        ]);
    }
    if($usuario->rol=="mortal"){
        $token = $usuario->createToken($request->email,['mortal'])->plainTextToken;
    }
    elseif($usuario->rol=="admin"){
        $token = $usuario->createToken($request->email,['admin'])->plainTextToken;
    }

    return response()->json(["token"=>$token],201);

    }




    public function cerrarSesion(Request $request){

        return response()->json(["Cerrar"=>$request->user()->tokens()->delete()],200);

    }




    public function subidaArc(Request $request){

        if($request->hasFile('nosirve')){
            $extension = $request->file('nosirve')->extension();
          if($extension=="png" || $extension=="jpg" || $extension=="jpg"){
            $path = Storage::disk('public')->putFile('imagen',$request->file);
          }else{
            return response()->json("Valio :,v",404);
          }
            
        }
        return response()->json(["Respuesta"=>$path],404);
    }




    public function subida(Request $request){
     if($request->hasFile('file')){

        $nuevoArchivo = new Documento();
        $nuevoArchivo->name = $request->name;
               $path = Storage::disk('public')->putFile('files',$request->file);
              
               $nuevoArchivo->path = $path;
               $nuevoArchivo->save();
               return response()->json($nuevoArchivo);

       }
       return response()->json(["name" => $request->name,
                                "file"  => $request->file
   ],200);
  }

  

    public function asas(Request $request){



     //   $extension = $request->file('file')->extension();
            $newFile = new Documento();
            $newFile->name=$request->name;
            $path = Storage::disk('public')->putFile('imagen',$request->file);
            $newFile->file=$request->$path;
            $newFile->save();
           /* $response = http::post('http://192.168.2.9:8000/api/guardar/archivo',[
              'file'=>$request->file
            ]);*/

  
           // return response()->json("Valio :,v",404);
          
        return response()->json(["Respuesta"=>$path],200);

    }

    public function prueba(Request $request){
      return "hola";
    }

    
}
