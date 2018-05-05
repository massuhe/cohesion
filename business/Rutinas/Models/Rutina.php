<?php

namespace Business\Rutinas\Models;

use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at', 'created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'alumno_id'];

    public function dias()
    {
        return $this->hasMany('Business\Rutinas\Models\DiaRutina');
    }

}