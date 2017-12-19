<?php
namespace Business\Usuarios\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['usuario_id', 'created_at', 'updated_at'];

    /** 
     * 
     */
    public function clasesEspecificas()
    {
        return $this->belongsToMany('Business\Clases\Models\ClaseEspecifica', 'asistencias')
            ->as('asistencia')
            // ->withPivot('asistio', 'justificacion')
            ->using('Business\Clases\Models\Asistencia');
    }

    public function usuario()
    {
        return $this->belongsTo('Business\Usuarios\Models\Usuario');
    }
}
