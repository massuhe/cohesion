<?php

namespace Business\Finanzas\Helpers;

class CuotaFormatter {

    public function formatDebe($debe)
    {
        $formatted = [];
        $deudas = explode('; ', $debe);
        forEach($deudas as $deuda){
            $deudaData = explode(': ', $deuda);
            $fechaDiv = explode('-', $deudaData[0]);
            $formatted[] = [
                'mes' => $fechaDiv[0],
                'anio' => $fechaDiv[1],
                'debe' =>  $deudaData[1]
            ];
        }
        return $formatted;
    }

}