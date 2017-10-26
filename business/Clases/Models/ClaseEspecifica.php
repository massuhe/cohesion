<?php
namespace Business\Clases\Models;

use Illuminate\Database\Eloquent\Model;

class ClaseEspecifica extends Model
{
    protected $table = 'clases_especificas';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at', 'created_at', 'deleted_at', 'fecha'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function descripcionClase()
    {
        return $this->belongsTo('Business\Clases\Models\Clase');
    }

    public function alumnos()
    {
        return $this->belongsToMany('Business\Usuarios\Models\Alumno', 'asistencias')
                    ->as('asistencia')
                    ->withPivot('asistio', 'justificacion')
                    ->using('Business\Clases\Models\Asistencia');
    }
}