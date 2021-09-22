<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table='proyectos';

    public function iniciativa(){
        return $this->hasOne('App\Models\Iniciativa','id','iniciativa_id');
    }
    public function documentos(){
        return $this->hasMany('App\Models\Documento','proyecto_id','id');
    }
    public function comentarios(){
        return $this->hasMany('App\Models\ComentarioProyecto','proyecto_id','id');
    }

}
