<?php

namespace Business\Finanzas\Factories;

use Business\Finanzas\Models\Pago;

class PagoFactory {

    public function createPago($data)
    {
        $pago = new Pago();
        $pago->importe = $data['importe'];
        return $pago;
    }

}