<?php

namespace Business\Rutinas\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class DetallesInvalidosException extends BusinessException {

    protected $message = 'Los detalles a cargar son inválidos';

}