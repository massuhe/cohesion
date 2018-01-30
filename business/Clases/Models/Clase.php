<?php
namespace Business\Clases\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at', 'created_at', 'deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function actividad()
    {
        return $this->belongsTo('Business\Actividades\Models\Actividad');
    }

    public function alumnos()
    {
        return $this->belongsToMany('Business\Usuarios\Models\Alumno', 'alumnos_clases');
    }

    public function clasesEspecificas()
    {
        return $this->hasMany('Business\Clases\Models\ClaseEspecifica', 'descripcion_clase');
    }

    public function suspensiones()
    {
        return $this->hasMany('Business\Clases\Models\Suspension');
    }
}