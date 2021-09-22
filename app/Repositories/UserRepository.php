<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version July 11, 2019, 2:39 pm -05
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'project_id',
        'active',
        'username',
        'password',
        'email',
        'email_verified_at',
        'remember_token',
        'device_imei',
        'device_token',
        'device_uuid',
        'device_battery_load',
        'device_version',
        'device_serial',
        'photo',
        'isAdmin'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
