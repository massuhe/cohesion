<?php

namespace Business\Finanzas\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class DebeNotNegativeException extends BusinessException{

    protected $message = 'La cantidad de pagos no puede superar al importe total';

}