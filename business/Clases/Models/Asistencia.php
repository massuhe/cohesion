<?php

namespace Business\Clases\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Asistencia extends Pivot
{
    protected $table = 'asistencias';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['alumno_id', 'clase_especifica_id'];
    
}