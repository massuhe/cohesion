<?php

namespace Business\Rutinas\Models;

use Illuminate\Database\Eloquent\Model;

class ParametroSemana extends Model
{
    protected $table = 'parametros_semana';
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
    protected $hidden = ['created_at', 'updated_at', 'item_serie_rutina_id'];

    public function parametros()
    {
        return $this->hasMany('Business\Rutinas\Models\ParametroItemSerie');
    }

}