<?php

namespace Business\Shared\Utils;

class StrUtils {

    public static function removeTildes($cadena) 
    {
        $vocales = ['a', 'e', 'i', 'o', 'u'];
        $vocalesTildes = ['á', 'é', 'í', 'ó', 'ú'];
        return str_replace($vocalesTildes, $vocales, $cadena);
    }
}