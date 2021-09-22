<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iniciativa extends Model
{
    protected $table='iniciativas';

    public function pilar(){
        return $this->hasOne('App\Models\Pilar','id','pilar_id');
    }
    public function proyectos(){
        return $this->hasMany('App\Models\Proyecto','iniciativa_id','id');
    }
}
