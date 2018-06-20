<?php

namespace Business\Rutinas\Helpers;

use Business\Shared\Services\MailService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Business\Usuarios\Models\Usuario;
use Business\Shared\Utils\SpanishMonthsUtils;

class NuevaRutinaNotifier {

    private $mailService;

    function __construct(MailService $ms)
    {
        $this->mailService = $ms;
    }

    public function notifyNuevaRutina()
    {
        $rutinasPorVencer = DB::table('rutinas')
            ->join('alumnos', 'rutinas.alumno_id', '=', 'alumnos.id')
            ->join('usuarios', 'alumnos.usuario_id', '=', 'usuarios.id')
            ->whereNull('rutinas.fecha_fin')
            ->whereRaw("DATE_ADD(rutinas.fecha_inicio, INTERVAL rutinas.total_semanas WEEK) = CURDATE()")
            ->get();
        $admin = Usuario::where('rol_id', 1)->first();
        forEach($rutinasPorVencer as $rutina) {
            $fechaFormatted = $this->formatDate(($rutina->fecha_inicio));
            $this->mailService->sendMail(
                'RECORDATORIO_RENOVAR_RUTINA',
                $admin->email,
                [
                    'nombre' => $rutina->nombre,
                    'apellido' => $rutina->apellido,
                    'fecha_inicio' => $fechaFormatted
                ]
            );
        }
    }

    private function formatDate($dateString)
    {
        $date = new Carbon($dateString);
        $day = $date->day;
        $mes = SpanishMonthsUtils::getMonth($date->month - 1);
        return "$day de $mes";
    }

}