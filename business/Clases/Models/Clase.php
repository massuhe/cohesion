<?php
namespace Business\Clases\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
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
        'created_at', 'updated_at'
    ];

    public function actividad()
    {
        return $this->hasOne('Business\Actividades\Models\Actividad');
    }

    public function alumnos()
    {
        return $this->belongsToMany('Business\Usuarios\Models\Alumno');
    }
}