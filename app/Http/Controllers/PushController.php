<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\Push;
use App\User;
use Illuminate\Support\Facades\Auth;
use Notification;



class PushController extends Controller
{

    public function __construct(){
      $this->middleware('auth');
    }

    /**
     * Store the PushSubscription.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        
        $user = Auth::user();
                // $user = \App\User::auth()->user();

        $user->updatePushSubscription($endpoint, $key, $token);
        
        
        return response()->json(['success' => true],200);
    }

    public function delete(Request $request){
        $user = Auth::user();
        $user->deletePushSubscription($request->endpoint);
        return response()->json(['subscripcion cancelada'],200);
    }

    // public function push(){
        
    //     $user = \App\User::find(auth()->user()->id);
    //     $user->notify(new PushDemo());
    //     return redirect()->back();
    // }

 
    public function push(){
        $user = Auth::user();     
        Notification::send($user,new Push);
         return redirect()->back();
    }
    

    /**********Borrador**********/
    public function getKey(){
        return response()->json([
            "ok" => true,
            "publicKey" => env('VAPID_PUBLIC_KEY'),
        ]);
    }

    public function getSubscripcion(){

    }
}