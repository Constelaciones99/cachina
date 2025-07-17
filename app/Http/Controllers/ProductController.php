<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Imagen;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function verTodo(){
        $productos=Auth::user()->productos()->with('imagenPrincipal')->get();

        return view('usuario.welcome',compact('productos'));
    }

    public function verAgregarProducto(){
            return view('usuario.crear');
    }

    public function agregarProducto(Request $request){

        $request->validate([
            'fotoProducto'=>'nullable|image|mimes:png,jpg,webp,jpeg|max:2048',
            'nombreProducto'=>'required|string|min:3',
            'stock'=>'required|numeric|min:1',
            'precio'=>'required|numeric|min:1',
            'detalles'=>'required|string|min:1'
        ]);
        

        $precios=[
            'anterior'=>$request->precio,
            'actual'=>$request->precio
        ];

        $producto=Producto::create([
            'id_usuario'=>Auth::id(),
            'nombre'=>$request->nombreProducto,
            'detalles'=>json_encode($request->detalles),
            'precios'=>json_encode($precios),
            'stock'=>$request->stock
        ]);

        $archivo=$request->file('fotoProducto');

        if(isset($archivo)){
            $nombre=time().'_'.$archivo->getClientOriginalName();
        $archivo->move(public_path('/imagenes/'),$nombre);

        Imagen::create([
            'id_producto'=>$producto->id,
            'ruta'=>'/imagenes/'.$nombre,
            'principal'=>1
        ]);
        return redirect()->route('home')->with('mensaje','Nuevo Producto Agregado!');
        }else{

            Imagen::create([
            'id_producto'=>$producto->id,
            'ruta'=>'/imagenes/noneimage.png',
            'principal'=>0
        ]);


        return redirect()->route('home')->with('mensaje','Nuevo Producto Agregado!');

        }



    }

     public function editarProducto($id){
            $producto=Producto::with('imagenPrincipal')->findOrFail($id);

            return view('productos.editar', compact('producto'));
    }

     public function modificarProducto(Request $request){

        $producto=Producto::findOrFail($request->id);

        $request->validate([
            'nombreProducto'=>'required|string|min:3',
            'detalles'=>'required|string|min:3',
            'precio'=>'required|numeric|min:1',
            'stock'=>'required|numeric|min:1'
        ]);

        $precios=[
            'anterior'=>json_decode($producto->precios)->actual,
            'actual'=>$request->precio
        ];

        $producto->nombre=$request->nombreProducto;
        $producto->detalles=json_encode($request->detalles);
        $producto->stock=$request->stock;
        $producto->precios=json_encode($precios);
        $producto->save();

        return redirect()->route('home');
    }


    public function eliminarProducto($id){

        $producto=Producto::findOrFail($id);
        $producto->delete($producto);

        return redirect()->route('home');

    }

    public function buscarProducto($clave=null){
        $usuario=Auth::id();

        $query=Producto::where('id_usuario',$usuario)
        ->with('imagenPrincipal');

        if(!empty($clave)){
        $query->whereRaw('LOWER(nombre) like ?',['%'.strtolower($clave).'%']);
        }

        $productos=$query ->get();

        return view('components.fragment', compact('productos'))->render();
    }

}
