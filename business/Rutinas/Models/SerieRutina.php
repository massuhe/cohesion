<?php

namespace Business\Rutinas\Models;

use Illuminate\Database\Eloquent\Model;

class SerieRutina extends Model
{
    protected $table = 'series_rutina';
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
    protected $hidden = ['created_at', 'updated_at', 'dia_rutina_id'];

    public function items()
    {
        return $this->hasMany('Business\Rutinas\Models\ItemSerieRutina');
    }

}