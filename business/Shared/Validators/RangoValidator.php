<?php

namespace Business\Shared\Validators;

class RangoValidator {

    public function validate($attribute, $value, $parameters, $validator) {
        if(!isset($value['horaDesde']) || !isset($value['horaHasta'])) {
            return false;
        }
        return $value['horaDesde'] <= $value['horaHasta'];
    }
}