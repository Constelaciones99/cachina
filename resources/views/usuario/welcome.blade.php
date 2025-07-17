@extends('layouts.styles')

@section('style')
        <style>


                *,html, body{
                        padding: 0;
                        margin: 0px 0px !important
                }

                ::-webkit-scrollbar{
                        display: none
                }

                body{
                        background: #ccc;
                }       

                header{
                        top: 0;
                        margin-top: 0;
                        position: fixed;
                        z-index: 1;
                }

                #alerta{
                        position: absolute;
                        right: 10px;
                        top: 10px;
                        z-index: 2;
                        animation: mostrar 2s linear forwards 
                }

                @keyframes mostrar{
                        99%{
                                opacity: 1;
                        }
                        100%{
                               
                                opacity: 0;
                        }
                }

                #btnAgregar{
                        margin: 75px 0px 35px 20px !important
                }

                #badge{
                        position: absolute;
                }
        </style>
@endsection

@section('content')

        @if (session('mensaje'))
            <h6 class="alert alert-success py-2 pe-5"    id="alerta">
               <x-alert>
               </x-alert>
                </h6>
        @endif

        <header class="bg-dark px-2 py-2 mb-5 me-5 w-100">
                <form action="{{ route('usuario.logout') }}" class="mt-1 d-flex justify-content-between">
                        @csrf
                        <h3 class="text-white">Marking!</h3>
                        
                        @if (isset($clave))

                        <input type="text" placeholder="Buscar mi producto ..." class="ms-2 ms-md-5 px-3 w-100 border-0 rounded-5 fs-5" id="buscar" value="{{ $clave }}">

                        @else

                        <input type="text" placeholder="Buscar mi producto ..." class="ms-2 ms-md-5 px-3 w-100 border-0 rounded-5 fs-5" id="buscar">
                            
                        @endif

                        <input type="submit" class="btn btn-transparent border border-light border-2  text-white ms-2 ms-md-5" value="cerrar sesion">
                </form>
        </header>

     

        <form action="{{ route('usuario.agregar') }}" 
        class="bg-transparent" id="btnAgregar">
        @csrf
                <input type="submit" value=" + Agregar Producto" class="btn btn-light border border-dark border-2">
        </form>


<div class="row mx-0 px-0" id="contenidoProductos">
        @forelse ( $productos as $producto )

        <div class="col-6 col-md-4 col-lg-3 col-xl-2 mx-0 px-0 d-flex justify-content-center" id="productos" data-id={{ $producto->id }}>
        <div class="card rounded-2 border border-dark mb-2" style="width:calc(100% - 10px); background:#ddd">
                               
        @if ($producto->imagenPrincipal )
        <img src="{{ asset($producto->imagenPrincipal->ruta) }}" class="card-img-top"> 

        <p class="badge text-bg-success m-1" id="badge">nuevo</p>
        
        @else
                                 
        <img src="{{ asset('imagenes/noneimage.png') }}" class="card-img-top">
                                        
        @endif

        <div class="card-body bg-dark rounded-bottom-2">
        <span class="card-title fw-bold fs-3 text-white">                             
                
        {{$producto->nombre}}
        </span> <br>
                                
        <span class="text-white">
                Stock: {{ $producto->stock }}
        </span> <br>
        <small class=" text-white">
                antes: 
                <span class=" text-decoration-line-through text-secondary">${{ json_decode($producto->precios)->anterior }}</span>
                                       
        </small>
        <small class="text-white">
                                        Ahora: 
        </small> 
        <span class="text-white fs-3">${{ json_decode($producto->precios)->actual }}</span>
                                
                </div>
        </div>
</div>
                        
        @empty
        
        <div class="col-12 d-flex justify-content-center">
                <img src="{{ asset('img/caja-vacia.png') }}" style="width: 10rem">
        </div>
        <p class="text-dark w-100 text-center">Aún no hay productos</p>
@endforelse
</div> 

<script>

document.querySelectorAll("#productos").forEach(producto => {
        producto.addEventListener("click", function(evt){
                const id=producto.dataset.id;
                
                window.location.href=`/usuario/editar/${id}`               
        })
});

document.getElementById("buscar").addEventListener("keyup",function(){
        const id=document.getElementById("buscar").value
        
        let buscar=async function(){
                try {
                        var req=await fetch(`/usuario/buscar/producto/${id}`)
                        var res=await req.text()
                        //console.log(res)
                        document.getElementById("contenidoProductos").innerHTML=res

                } catch (error) {
                        console.log(error)
                }
        }

        buscar()

})
                        
        </script>

@endsection