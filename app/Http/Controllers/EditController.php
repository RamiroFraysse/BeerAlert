<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;



class EditController extends Controller
{
    function showEditView($id){
        if(auth()->user()!=null){
            $user = User::find($id);
            return view('edit', ['user' => $user]);
        }else
            return redirect('login');
    }

    public function update($id){
        if(auth()->user()!=null){

            $data = request()->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($id)], //En la busqueda me tiene que ignorar el mail actual del usuario.
                'ssid' => '',
                'password' => '',
            ]);

            if($data['password'] != null){
                $data['password'] = bcrypt($data['password']);
            }else{
                //Usamos unset para quitar el indice password del array asociativo de la variable data
                unset($data['password']);

            }
            $user = User::find($id);

            $user->update($data);

            
            return redirect('home');
        }else
            return redirect('login');

    }   
}
