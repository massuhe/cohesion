<?php

namespace Business\Finanzas\Validators;

use Business\Finanzas\Exceptions\DebeNotNegativeException;

class CuotaValidator
{
    public function validateDebeNotNegative($cuota)
    {
        $importeTotal = $cuota->importe_total;
        $pagos = $cuota->pagos;
        $importePagado = 0;
        forEach($pagos as $pago) {
            $importePagado += $pago->importe;
        }
        if ($importeTotal - $importePagado < 0) {
            throw new DebeNotNegativeException();
        }
    }
}