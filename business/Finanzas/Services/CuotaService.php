<?php

namespace Business\Finanzas\Services;

use Business\Finanzas\Repositories\CuotaRepository;
use Business\Finanzas\Factories\CuotaFactory;
use Business\Usuarios\Services\UsuarioService;
use Illuminate\Support\Facades\Config;
use Business\Finanzas\Factories\PagoFactory;
use Illuminate\Support\Facades\DB;
use Business\Finanzas\Validators\CuotaValidator;

class CuotaService {

    private $cuotaRepository;
    private $usuarioService;
    private $cuotaFactory;
    private $pagoFactory;
    private $cuotaValidator;

    public function __construct(
        CuotaRepository $cr,
        CuotaFactory $cf,
        PagoFactory $pf,
        UsuarioService $us,
        CuotaValidator $cv
    )
    {
        $this->cuotaRepository = $cr;
        $this->cuotaFactory = $cf;
        $this->pagoFactory = $pf;
        $this->usuarioService = $us;
        $this->cuotaValidator = $cv;
    }

    public function findWithFallback($alumno, $mes, $anio)
    {
        $cuota = $this->cuotaRepository->getWhereArray([
            ['alumno_id', $alumno],
            ['mes', $mes],
            ['anio', $anio]
        ]);
        if(sizeOf($cuota) === 0) {
            $importeTotal = $this->calculateImporteTotalSegunClases($alumno);
            return $this->cuotaFactory->createCuota([
                'alumno' => $alumno, 
                'mes' => $mes, 
                'anio' => $anio, 
                'importeTotal' => $importeTotal]
            );
        }
        return $cuota[0]->load('pagos');
    }

    public function createOrUpdateIfExists($data)
    {
        $cuota = $this->cuotaRepository->getWhereArray([
            ['alumno_id', $data['alumno']],
            ['mes', $data['mes']],
            ['anio', $data['anio']]
        ]);
        return DB::transaction(function() use($cuota, $data) {
            if (sizeOf($cuota) === 0) {
                $cuotaSinID = $this->cuotaFactory->createCuota($data);
                $cuota = $this->cuotaRepository->store($cuotaSinID);
            } else {
                $cuota = $this->cuotaRepository->update($cuota[0], $data);
            }
            $this->registrarPago($cuota, $data['importePaga']);
            $this->cuotaValidator->validateDebeNotNegative($cuota);
            return $cuota->load('pagos');
        });
    }

    private function calculateImporteTotalSegunClases($alumno)
    {
        $numClasesAlumno = $this->usuarioService->getCantidadClasesAlumno($alumno);
        return Config::get('business.PRECIO_CLASES')[$numClasesAlumno];
    }

    private function registrarPago($cuota, $importe)
    {
        $pago = $this->pagoFactory->createPago(['importe' => $importe]);
        $this->cuotaRepository->registrarPago($cuota, $pago);
    }

}