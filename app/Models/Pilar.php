<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilar extends Model
{
    protected $table='pilares';

    public function iniciativas(){
        return $this->hasMany('App\Models\Iniciativa','pilar_id','id');
    }

    public function municipio(){
        return $this->hasOne('App\Models\Municipio','id','municipio_id');
    }
}
