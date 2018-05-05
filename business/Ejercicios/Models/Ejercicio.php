<?php

namespace Business\Ejercicios\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
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
    protected $hidden = ['updated_at', 'tipo_ejercicio_id'];

    public function tipoEjercicio()
    {
        return $this->belongsTo('Business\Ejercicios\Models\TipoEjercicio');
    }

}