<?php

namespace Business\Seguridad\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Business\Seguridad\Models\Rol;
use Business\Usuarios\Models\Usuario;

class RolesController extends Controller {

    public function caca()
    {
        return Usuario::with('rol')->first();
    }
}