<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table='mensajes';
    protected $appends=['hora','fecha'];

    public function destino(){
        return $this->hasOne('App\User','id','destino_id');
    }

    public function origen(){
        return $this->hasOne('App\User','id','origen_id');
    }

    public function getHoraAttribute()
    {
        return date('H:i',strtotime($this->created_at));
    }

    public function getFechaAttribute()
    {
        \Carbon\Carbon::setLocale('es');
        $fecha = \Carbon\Carbon::parse($this->created_at);

        return $fecha->format('d F Y');
    }
}
