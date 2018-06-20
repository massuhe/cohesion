<?php

namespace Business\Finanzas\Services;

use Business\Finanzas\Repositories\PagoRepository;

class PagoService {

    private $pagoRepository;
    
    public function __construct(
        PagoRepository $pr
    )
    {
        $this->pagoRepository = $pr;
    }

    public function getByMesCuota($mes, $anio)
    {
        return $this->pagoRepository->getByMesCuota($mes, $anio);
    }

    public function getByAlumnoYFechas($idAlumno, $fechaDesde, $fechaHasta)
    {
        return $this->pagoRepository->getByAlumnoYFechas($idAlumno, $fechaDesde, $fechaHasta);
    }

}