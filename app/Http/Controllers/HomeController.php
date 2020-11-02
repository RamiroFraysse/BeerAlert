<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Dato;

date_default_timezone_set('America/Argentina/Buenos_Aires');


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        if(auth()->user()!=null){
            $SSID = auth()->user()->ssid;
            $mes = date("m");
            $dia = date("d");
            $ano= date("Y");
            
            $fecha = $ano.'-'.$mes.'-'.$dia;
            // $datos = DB::table('datos')->whereDate('fecha',$fecha)->where('SSID',$SSID)->select('fecha','temperatura')->get();
            $dato_ini = DB::table('datos')->where('serie','1')->orderBydesc('fecha')->select('fecha')->first();
            $fecha_ini = $dato_ini->fecha;
            $datos = Dato::whereDay('fecha','<=',$fecha_ini)->get();
            //Temperatura actual
            $temp_actual = DB::table('datos')->whereDate('fecha',$fecha)->where('SSID',$SSID)->select('fecha','temperatura')->orderBydesc('fecha')->first();
            if($temp_actual!=null && $dato_ini!=null){
                return view('home',
                [   'datos'=> $datos,
                    'SSID' => $SSID,
                    'temp_actual' => $temp_actual->temperatura,
                    'dato_ini' => $dato_ini->fecha
                ]);
            }else{
                return view('home',
                ['datos'=> $datos,
                    'SSID' => $SSID,
                    'temp_actual' => -200,
                ]);
            }   
        }else{
            return view('welcome');
        }
    }
}
