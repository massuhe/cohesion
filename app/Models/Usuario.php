<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];

    public function alumno()
    {
        return $this->hasOne('App\Models\Alumno');
    }

    public static function newFromRequest($request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->get('nombre');
        $usuario->apellido = $request->get('apellido');
        $usuario->email = $request->get('email');
        $usuario->password = $request->get('password');
        $usuario->domicilio = $request->get('domicilio');
        $usuario->telefono = $request->get('telefono');
        $usuario->observaciones = $request->get('observaciones');
        $usuario->activo = true;
        return $usuario;
    }
}
