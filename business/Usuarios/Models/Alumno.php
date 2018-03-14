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
    public function clases()
    {
        return $this->belongsToMany('Business\Clases\Models\Clase', 'alumnos_clases');
    }

    public function clasesEspecificas()
    {
        return $this->belongsToMany('Business\Clases\Models\ClaseEspecifica', 'asistencias')
            ->as('asistencia')
            ->withPivot('asistio')
            ->using('Business\Clases\Models\Asistencia');
    }

    public function usuario()
    {
        return $this->belongsTo('Business\Usuarios\Models\Usuario');
    }

    public function posibilidadesRecuperar()
    {
        return $this->hasMany('Business\Clases\Models\PosibilidadRecuperar');
    }

    public function cuotas()
    {
        return $this->hasMany('Business\Finanzas\Models\Cuota');
    }
}
