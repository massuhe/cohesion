<?php

namespace Business\Rutinas\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSerieRutina extends Model
{
    protected $table = 'items_serie_rutina';
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
    protected $hidden = ['created_at', 'updated_at', 'serie_rutina_id', 'ejercicio_id'];

    public function ejercicio()
    {
        return $this->belongsTo('Business\Ejercicios\Models\Ejercicio');
    }

    public function parametrosSemana()
    {
        return $this->hasMany('Business\Rutinas\Models\ParametroSemana');
    }

}