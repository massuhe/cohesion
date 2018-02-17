<?php

namespace Business\Seguridad\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model {

    protected $table = 'roles';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

        /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function permisos()
    {
        return $this->belongsToMany('Business\Seguridad\Models\Permiso', 'roles_permisos')->as('permisos');
    }
    

}