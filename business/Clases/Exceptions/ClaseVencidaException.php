<?php

namespace Business\Clases\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class ClaseVencidaException extends BusinessException{

    protected $message = 'La clase ya ha ocurrido';

}