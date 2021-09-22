<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioProyecto extends Model
{
    protected $table='comentarios_proyectos';

    function user(){
        return $this->hasOne('App\User','id','user_id');
    }
}
