<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Notifications\Push;
use App\Notifications\Push2;
use App\User;
use Notification;



class DatosController extends Controller
{
    // public function showView(){
    //     return view('prueba2');
    // }
    public function store(Request $request){
        //Tomar datos desde un formulario
         $serie = $request->serie; 
         $temperatura_envase = $request->temperatura_envase;
         $temperatura =$request->temperatura ;
         $ssid = $request->ssid;
         DB::table('datos')->insert(['serie' => $serie,
                                     'temperatura_envase' => $temperatura_envase,
                                     'temperatura' => $temperatura,
                                     'ssid' => $ssid,
                                    ]);
         $user = \App\User::where('ssid',$ssid)->first();                         
         //logica de enviar wp y notificación
         if($temperatura==3 || $temperatura==1){
                 $user->notify(new \App\Notifications\Push());
                 return response()->json([
                     "ok" => true,
                     "data" => $user,
                 ]);
         }else if($temperatura<=0){
             $user->notify(new \App\Notifications\Push2());
             return response()->json([
                 "ok" => true,
                 "data" => $user,
             ]);
         }
             return redirect()->action('HomeController@index');
         }
}
