<?php

namespace Business\Finanzas\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
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
    protected $hidden = ['updated_at'];

    public function cuota()
    {
        return $this->belongsTo('Business\Finanzas\Models\Cuota');
    }

}