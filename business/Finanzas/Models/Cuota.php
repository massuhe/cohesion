<?php

namespace Business\Finanzas\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
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

    public function pagos()
    {
        return $this->hasMany('Business\Finanzas\Models\Pago');
    }

    public function alumno()
    {
        return $this->belongsTo('Business\Usuarios\Models\Alumno');
    }

}