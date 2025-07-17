<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Usuario;
use App\Models\Rol;


class LoginController extends Controller
{

    public function iniciarSesion(Request $request){
        $request->validate([
            'usuario'=>'required|string|min:3',
            'clave'=>'required|string|min:3'
        ]);

        if(Auth::attempt([
            'usuario'=>$request->usuario,
            'password'=>$request->clave
        ])){
            session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'Error'=>'Usuario y/o contraseña incorrecto(s).'
        ]);


    }

    public function registrarUsuario(Request $request){

        $request->validate([
            'nombre'=>'required|string|min:3',
            'usuario'=>'required|string|min:3',
            'clave'=>'required|string|min:3',
            'rol'=>'required|numeric'
        ]);


        $usuario=Usuario::create([
            'nombre'=>$request->nombre,
            'usuario'=>$request->usuario,
            'clave'=>Hash::make($request->clave)
        ]);

        Rol::create([
            'id_usuario'=>$usuario->id,
            'rol'=>$request->rol,
            'activo'=>1
        ]);

        Auth::login($usuario);
    
        return redirect()->route('home');

    }

    public function cerrarSesion(Request $request){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
    }

    public function usuarioLogin(){
        if(Auth::check()){
            return redirect()->route('home');
        }

        return view('login');
    }

    public function usuarioRegistro(){
        if(Auth::check()){
            return redirect()->route('home');
        }

        return view('registro');
    }

}
