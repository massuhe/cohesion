<?php

namespace Business\Seguridad\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model {

    protected $table = 'permisos';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'permisos'];
    

}