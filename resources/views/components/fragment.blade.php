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