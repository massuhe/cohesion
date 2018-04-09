<?php

namespace Business\Shared\Utils;

class SpanishMonthsUtils {

    public static function getMonth($numberMonth)
    {
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        return $months[$numberMonth];
    }

}