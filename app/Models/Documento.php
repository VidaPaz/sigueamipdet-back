<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table='documentos';
    protected $appends=['link'];

    public function getLinkAttribute()
    {
        return route('download').'?id='.$this->id;
    }
}
