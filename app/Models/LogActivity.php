<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table= 'log_actividades';


    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }

}
