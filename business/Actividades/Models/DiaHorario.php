<?php

namespace Business\Actividades\Models;

use Illuminate\Database\Eloquent\Model;

class DiaHorario extends Model
{
    protected $table = 'dias_horarios';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at','created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'id'
    ];

    public function horarios()
    {
        return $this->hasMany('Business\Actividades\Models\RangoHorario');
    }
}