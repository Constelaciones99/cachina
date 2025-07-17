@extends('layouts.html')


@section('content')

        <div class="row">
            <div class="col-12 w-100 d-flex justify-content-center">
                <form action="{{ route('usuario.agregarProducto') }}" enctype="multipart/form-data" class="mt-5 p-5 rounded-2" method="post">
                    @csrf
                    <h4>Registrar Producto</h4>
                    <hr>
                    <label for="files" class="mb-4 w-100" id="labelInputFile">
                        <span class="btn btn-secondary text-dark rounded-5 py-0 w-100" id="spanInputFile"><x-camera /></span>
                        <input type="file" id="files" name="fotoProducto" hidden>
                    </label>
                    <input type="text" placeholder="Nombre" class="fs-5 rounded-1 border-0 w-100 mb-1 py-2 px-3" name="nombreProducto"><br>
                    <input type="number" placeholder="stock" class="fs-5 rounded-1 border-0 w-100 mb-1 py-2 px-3" name="stock"><br>
                    <input type="number" placeholder="precio" class="fs-5 rounded-1 border-0 w-100 mb-1 py-2 px-3" name="precio"><br>
                    <textarea placeholder="Detalles" class="form-control mb-4" rows="3"  name="detalles">
                    </textarea>
                    <p class="w-100 d-flex justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-secondary me-1 w-50">Cancelar</a>
                    <input type="submit" class="btn btn-warning ms-1 w-50" value="Registrar">
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

    </script>

@endsection