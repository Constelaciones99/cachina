<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Producto;

class Imagen extends Model
{
    protected $table='imagens';

    protected $fillable=[
        'id_producto',
        'ruta',
        'principal'
    ];

    public function productos(){
        return $this->belongsTo(Producto::class,'id_producto');
    }

}
