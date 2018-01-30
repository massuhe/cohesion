<?php

namespace Business\Clases\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class NoAsisteAClaseException extends BusinessException{

    protected $message = 'El alumno no asiste a la clase especificada';

}