<?php
namespace Business\Actividades\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
    use SoftDeletes;

    protected $table = 'actividades';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at','created_at','deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function dias_horarios()
    {
        return $this->hasMany('Business\Actividades\Models\DiaHorario');
    }
}