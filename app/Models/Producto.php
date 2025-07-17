<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Usuario;
use App\Models\Imagen;


class Producto extends Model
{
    protected $table='productos';

    protected $fillable=[
        'id_usuario',
        'nombre',
        'detalles',
        'precios',
        'stock'
    ];

    protected $casts=[
        'detalles'=>'array',
        'precios'=>'array'
    ];


    public function usuario(){
        return $this->belongsTo(Usuario::class,'id_usuario');
    }

    public function imagenPrincipal(){
        return $this->hasOne(Imagen::class,'id_producto')->where('principal',1);
    }

}
