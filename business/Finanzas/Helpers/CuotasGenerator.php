<?php

namespace Business\Finanzas\Helpers;

use Business\Usuarios\Models\Usuario;
use Business\Finanzas\Models\Cuota;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class CuotasGenerator {

    public function generate($mes, $anio) {
        $usuarios = Usuario::whereHas('alumno', function ($query) use ($mes, $anio) {
            $query->whereDoesntHave('cuotas', function($q) use ($mes, $anio) {
                $q->where([['mes', $mes],['anio', $anio]]);
            });
        })->with('alumno')->with('alumno.clases')->where('activo', true)->get();
        $inserts = $usuarios->map(function ($u) use ($mes, $anio) {
            $numClases = sizeOf($u->alumno->clases);
            return [
                'mes' => $mes,
                'anio' => $anio,
                'alumno_id' => $u->alumno->id,
                'importe_total' => Config::get('business.PRECIO_CLASES')[$numClases],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        })->toArray();
        Cuota::insert($inserts);
    }

}