<?php
namespace Business\Usuarios\Models;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'usuarios';

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
        'password', 'remember_token', 'deleted_at', 'created_at', 'updated_at', 'rol_id'
    ];

    public function alumno()
    {
        return $this->hasOne('Business\Usuarios\Models\Alumno');
    }

    public function rol()
    {
        return $this->belongsTo('Business\Seguridad\Models\Rol');
    }

    public function isAlumno()
    {
        return $this->alumno();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        $permisos = collect($this->rol->permisos->map(function ($p) {
            return $p->only(['nombre']);
        }))->flatten();
        return ['email' => $this->email, 'nombre' => $this->nombre . ' ' . $this->apellido, 'permisos' => $permisos];
    }
}
