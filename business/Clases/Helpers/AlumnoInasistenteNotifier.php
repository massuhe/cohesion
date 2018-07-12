<?php

namespace Business\Clases\Helpers;

use Business\Shared\Services\MailService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Business\Usuarios\Models\Usuario;
use Business\Shared\Utils\SpanishMonthsUtils;

class AlumnoInasistenteNotifier {

    private $mailService;

    function __construct(MailService $ms)
    {
        $this->mailService = $ms;
    }

    public function notifyAlumnoInasistente()
    {
        $admin = Usuario::where('rol_id', 1)->first();
        $alumosInasistentesHoy = $this->getAlumnosInasistentesHoy();
        forEach($alumosInasistentesHoy as $alumno) {
            $tiene3InasistenciasSeguidas = $this->checkTiene3InasistenciasSeguidas($alumno->id);
            if (!$tiene3InasistenciasSeguidas) {
                return ;
            }
            $this->notifyAdmin($admin, $alumno);
            $this->notifyAlumno($alumno);
        }
    }

    private function getAlumnosInasistentesHoy()
    {
        $today = Carbon::now()->addDays(6)->toDateString();
        $alumnos = DB::table('asistencias')
          ->select('alumnos.id', 'usuarios.email', 'usuarios.nombre','usuarios.apellido')
          ->distinct()
          ->join('clases_especificas', 'asistencias.clase_especifica_id', 'clases_especificas.id')
          ->join('alumnos', 'asistencias.alumno_id', 'alumnos.id')
          ->join('usuarios', 'alumnos.usuario_id', 'usuarios.id')
          ->where([
              ['clases_especificas.fecha', $today],
              ['asistencias.asistio', false]
            ])
          ->get();
        return $alumnos;
    }

    private function checkTiene3InasistenciasSeguidas($alumnoId)
    {
        $ultimas3ClasesAlumno = DB::table('asistencias')
          ->select('asistencias.id')
          ->join('clases_especificas', 'asistencias.clase_especifica_id', 'clases_especificas.id')
          ->where('asistencias.alumno_id', $alumnoId)
          ->orderBy('clases_especificas.fecha', 'desc')
          ->orderBy('clases_especificas.id', 'desc')
          ->limit(3);
        $inasistenciasCount = DB::table(DB::raw("({$ultimas3ClasesAlumno->toSql()}) as temp"))
          ->mergeBindings($ultimas3ClasesAlumno)
          ->count();
        return $inasistenciasCount === 3;
    }

    private function notifyAdmin($admin, $alumno)
    {
        $this->mailService->sendMail(
            'ALUMNO_INASISTENTE_ADMIN',
            $admin->email,
            [
                'nombre' => $alumno->nombre,
                'apellido' => $alumno->apellido
            ]
        );
    }

    private function notifyAlumno($alumno)
    {
        $this->mailService->sendMail(
            'ALUMNO_INASISTENTE',
            $alumno->email,
            [
                'nombre' => $alumno->nombre,
                'apellido' => $alumno->apellido
            ]
        );
    }

}