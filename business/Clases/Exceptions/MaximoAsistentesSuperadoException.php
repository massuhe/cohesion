<?php

namespace Business\Clases\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class MaximoAsistentesSuperadoException extends BusinessException{

    protected $message = 'La cantidad de asistentes supera el máximo permitido por la actividad';

}