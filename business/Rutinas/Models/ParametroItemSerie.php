<?php

namespace Business\Rutinas\Models;

use Illuminate\Database\Eloquent\Model;

class ParametroItemSerie extends Model
{
    protected $table = 'parametros_item_serie';
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
    protected $hidden = ['created_at', 'updated_at', 'parametro_semana_id'];

    public function clase() {
        return $this->belongsTo('Business\Clases\Models\ClaseEspecifica', 'clase_especifica_id');
    }


}