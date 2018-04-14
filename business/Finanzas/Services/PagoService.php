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

    public function getAllPagos()
    {
        return $this->pagoRepository->getAllPagos();
    }

}