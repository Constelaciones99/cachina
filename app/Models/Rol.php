<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Usuario;

class Rol extends Model
{
    protected $table='rols';

    protected $fillable=[
        'id_usuario',
        'rol',
        'activo'
    ];

    protected $casts=[
        'rol'=>'integer',
        'activo'=>'integer'
    ];

    public function usuarios(){
        return $this->belongsTo(Usuario::class,'id_usuario');
    }


}
