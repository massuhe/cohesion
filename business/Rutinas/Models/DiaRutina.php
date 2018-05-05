<?php

namespace Business\Rutinas\Models;

use Illuminate\Database\Eloquent\Model;

class DiaRutina extends Model
{
    protected $table = 'dias_rutina';
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
    protected $hidden = ['created_at', 'updated_at', 'rutina_id'];

    public function series()
    {
        return $this->hasMany('Business\Rutinas\Models\SerieRutina');
    }

}