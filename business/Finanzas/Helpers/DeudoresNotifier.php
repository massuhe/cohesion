<?php

namespace Business\Finanzas\Helpers;

use Business\Usuarios\Repositories\AlumnoRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Business\Shared\Services\MailService;
use Business\Shared\Utils\SpanishMonthsUtils;

class DeudoresNotifier {

    private $alumnoRepository;
    private $mailService;

    function __construct(AlumnoRepository $ar, MailService $ms)
    {
        $this->alumnoRepository = $ar;
        $this->mailService = $ms;
    }

    public function notifyDeudores()
    {
        $today = Carbon::now();
        $mesToday = $today->month;
        $alumnos = $this->alumnoRepository->listado();
        $deudores = collect($alumnos)->filter(function($a) use ($mesToday) {
            return $a->debe && $this->alumnoDebeMes($a->debe, $mesToday);
        });
        forEach($deudores as $d) {
            $totalDebeMes = '$'.explode(': ', $d->debe)[1];
            $this->mailService->sendMail(
                'RECORDATORIO_PAGO',
                $d->email,
                [
                    'nombre' => $d->nombre,
                    'apellido' => $d->apellido,
                    'mes' => SpanishMonthsUtils::getMonth($mesToday),
                    'total_debe_mes' => $totalDebeMes
                ]
            );
        }
    }

    private function alumnoDebeMes($deudas, $mesToday)
    {
        $deudasArray = explode(';', $deudas);
        $debe = collect($deudasArray)->first(function($d) use ($mesToday) {
            return intval(substr($d, 0, 1)) === $mesToday;
        }) !== null;
        return $debe;
    }

}