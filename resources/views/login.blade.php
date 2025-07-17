@extends('layouts.html')

@section('content')

<div class="container pt-5">
    <div class="row pt-5 d-flex justify-content-center">
        <div class="col-12 col-md-6">
            <form action="{{ route('usuario.login') }}" class="rounded-2 p-5">
                <h4>Log in</h4>
                @if ($errors->has('Error'))
                    <span class="text-danger">
                        {{ $errors->first('Error')}}
                    </span>
                @endif

                @if ($errors->has('mensaje'))
                    <span class="text-danger">
                        {{ $errors->first('mensaje')}}
                    </span>
                @endif
                <hr>

                <input type="text" placeholder="Ingrese Usuario" class="mb-1 w-100 rounded-1 py-2 fs-5 border-0 px-3" name="usuario"><br>
                <input type="password" placeholder="Ingrese Contraseña" class="mb-2 w-100 rounded-1 py-2 fs-5 border-0 px-3" name="clave"> <br>
                <input type="submit" class="w-100 btn btn-primary" class="Ingresar">
                <span>Aún no tienes una cuenta?
                    <a href="{{ route('usuario.registrarse')}}">Registrate</a>
                </span>
            </form>
        </div>
    </div>
</div>

@endsection