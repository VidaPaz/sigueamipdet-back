<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoFavorito extends Model
{
    protected $table='proyectos_favoritos';

    public function proyecto(){
        return $this->hasOne('App\Models\Proyecto','id','proyecto_id');
    }
}
