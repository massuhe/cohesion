<?php

namespace Business\Finanzas\Services;

class CuotaService {

    private $cuotaRepository;

    public function __construct()
    {
        
    }

    public function getOrCreateCuota($data)
    {
        $cuota = $this->cuotaRepository->getByParams($data['alumno'], $data['mes'], $data['anio']);
        if (!$cuota) {
            $cuota = $this->cuotaFactory->createCuota($data);
            $cuota = $this->cuotaRepository->store($cuota);
        }
        $cuota->load('pagos');
        return $cuota;
    }
}