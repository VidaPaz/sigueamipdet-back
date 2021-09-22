<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table='rutas';
    protected $appends = ['url_image'];

    public function getUrlImageAttribute(){
        return url('/rutas/'.$this->imagen);
    }
}
