<?php
namespace Business\Clases\Models;

use Illuminate\Database\Eloquent\Model;

class PosibilidadRecuperar extends Model
{
    protected $table = 'posibilidades_recuperar';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['valido_hasta'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['valido_hasta'];

    public $timestamps = false;

}