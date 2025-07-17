<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

use App\Models\Producto;
use App\Models\Rol;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{

    protected $table='usuarios';

    protected $fillable=[
        'nombre',
        'ape_pat',
        'ape_mat',
        'usuario',
        'clave',
        'email',
        'dni',
        'perfil'
    ];

    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function productos(){
        return $this->hasMany(Producto::class, 'id_usuario');
    }

    public function rols(){
        return $this->hasOne(Rol::class,'id_usuario');
    }
    
}
