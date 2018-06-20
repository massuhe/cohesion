<?php

namespace Business\Clases\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class ClaseVencidaException extends BusinessException {

    protected $message = 'Ya no es posible reservar esta clase';

}