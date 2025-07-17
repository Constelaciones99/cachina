@extends('layouts.html')

@section('content')

<div class="container pt-5">
    <div class="row pt-5 d-flex justify-content-center">
        <div class="col-12 col-md-6">
            <form action="{{ route('usuario.registro') }}" class="p-5 rounded-2">
                <h4>Registro</h4>
                <hr>
                {{-- errors--}}
                <input type="text" placeholder="Nombres" class="mb-1 w-100 rounded-1 py-2 fs-5 border-0 px-3" name="nombre">
                <input type="text" placeholder="Usuario" class="mb-1 w-100 rounded-1 py-2 fs-5 border-0 px-3" name="usuario"><br>
                <input type="password" placeholder="Contraseña" class="mb-2 w-100 rounded-1 py-2 fs-5 border-0 px-3" name="clave">
                <input type="number" id="resp" name="rol" value="2" hidden>
                <br>

                <span class="btn-group mb-2 w-100">
                    <button class="btn border-dark" id="btncheck" data-btn="0">Vender</button>
                    <button class="btn border-dark" id="btncheck" data-btn="1">Comprar</button>
                    <button class="btn btn-info border-dark" id="btncheck" data-btn="2">Ambos</button>
                </span>

                <br>
                <input type="submit" class="w-100 btn btn-success" value="Registrar">
                <a href="{{ route('login') }}" class="btn btn-secondary w-100 mt-1">Regresar</a>
            </form>
        </div>
    </div>
</div>

<script>

document.querySelectorAll("#btncheck").forEach(btn=>{
    btn.addEventListener("click", function(e){
        //alert(btn.dataset.btn)
        e.preventDefault();
        
        document.querySelectorAll("#btncheck")[0].classList.remove("btn-info")
        document.querySelectorAll("#btncheck")[1].classList.remove("btn-info")
        document.querySelectorAll("#btncheck")[2].classList.remove("btn-info")


        document.querySelectorAll("#btncheck")[btn.dataset.btn].classList.add("btn-info")

        document.getElementById("resp").value=btn.dataset.btn
    })
})


</script>

@endsection