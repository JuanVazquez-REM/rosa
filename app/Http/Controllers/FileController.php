<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\File;
use GuzzleHttp\Psr7\Response;

class FileController extends Controller
{

        public function subidas_archivo(Request $request){

            if($request->hasFile('file')){ //pregunto si existe un archivo en request
                      $path = Storage::disk('public')->putFile('files',$request->file);//guardo el archivo recivido por api 1
                      
                      $nuevoArchivo = new Documento;
                      $nuevoArchivo->name = $request->name;
                      $nuevoArchivo->file = $path;
                      $nuevoArchivo->save(); //guardo la direccion en una BD de api 2

                    return Storage::disk('public')->download($request->file);//descargo el archivo y lo retorno/muestro a api 1
              }
              return response()->json(["name" => $request->name,"file"  => $request->file],200);
        }

        public function metodoAlt(Request $request){

           // $request->cliente;
            $response = new Response();
            $response->getBody()->getContents();
            return $response;
         }


             
         
       
     /*if($request->hasFile('file')){
        // $extension = $request->file('file');  //->extension();
          $path = Storage::disk('public')->putFile('archivos/img',$request->file); 
     }
         return Storage::disk('public')->get('archivos/img/wyRzaaxxcrxMQUS6CFttHdspin1XdD9VCnkdiwzU');
     }*/
  }

