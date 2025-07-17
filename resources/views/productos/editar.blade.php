@extends('layouts.html')

@section('content')

    <div class="row">
        <div class="col-12 w-100 d-flex justify-content-center">
            <form action="{{ route('usuario.productoEditado') }}" enctype="multipart/form-data" class="mt-2 p-5 rounded-2" method="POST">

                @csrf

                <h4>Editar Producto</h4>
                <hr>

                <span class="mb-1">Cambiar foto:</span>

        <label for="files" class="mb-4 w-100" id="labelInputFile">
                        <span class="btn btn-secondary text-dark rounded-5 py-0 w-100" id="spanInputFile"><x-camera /></span>
                        <input type="file" id="files" name="imagen" hidden>
        </label>

        <input hidden type="text" name="id" value="{{ $producto->id }}" id="idProducto">

        <input type="text" class="px-3 py-2 fs-5 rounded-1 w-100 mb-1" placeholder="Nombre" value="{{ $producto->nombre }}" name="nombreProducto">
        <textarea class="form-control mb-1" rows="3" placeholder="Detalles de Producto..." name="detalles">{{ json_decode($producto->detalles) }}</textarea>
        <input type="number" class="px-3 py-2 fs-5 rounded-1 w-100 mb-1" placeholder="precio" value="{{ json_decode($producto->precios)->actual }}" name="precio"><br>
        <input type="number" class="px-3 py-2 fs-5 rounded-1 w-100 mb-1" placeholder="stock" value="{{ $producto->stock }}" name="stock">

         <p class="w-100  mt-2">
                    <a href="{{ route('home') }}" class="btn btn-secondary" style="width: calc(50% - 3px)">Cancelar</a>
                    <input type="submit" class="btn btn-warning" value="Editar" style="width: calc(50% - 3px)">
                    <a class="btn btn-dark w-100 mt-1" id="btnEliminar" >Eliminar Producto</a>
                    </p>

    </form>

        </div>
    </div>


    <script>
    document.getElementById("files").addEventListener("change", function(evt){
        
        if(evt.target.files[0]){
        document.getElementById('spanInputFile').classList.remove('btn-secondary')
        document.getElementById('spanInputFile').classList.add('btn-warning')

        document.getElementById('spanInputFile').innerHTML=`<x-camera2 />`

        }else{
            document.getElementById('spanInputFile').classList.remove('btn-warning')
        document.getElementById('spanInputFile').classList.add('btn-secondary')

        document.getElementById('spanInputFile').innerHTML=`<x-camera />`
        }
    })


    document.getElementById("btnEliminar").addEventListener("click",function(){
        const id=document.getElementById("idProducto").value

        window.location.href=`/usuario/producto/eliminar/${id}`
    })

    </script>

@endsection