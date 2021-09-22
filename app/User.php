<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait;

    public function findForPassport($identifier) {
        return $this->where('username', $identifier)->where('active',1)->first();
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function chats_unread(){
        return $this->hasMany('App\Models\Mensaje','destino_id','id')->where('read',0);
    }

    public function chats(){
        return $this->hasMany('App\Models\Mensaje','destino_id','id');
    }

    public function municipio(){
        return $this->hasOne('App\Models\Municipio','id','municipio_id');
    }


}
