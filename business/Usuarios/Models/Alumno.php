<?php
namespace Business\Usuarios\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'usuario_id'
    ];

    public static function newFromRequest($request)
    {
        $alumno = new Alumno();
        $alumno->tiene_antec_deportivos = $request['tieneAntecDeportivos'];
        return $alumno;
    }

    public function getAlumno($userId)
    {

    }
}
