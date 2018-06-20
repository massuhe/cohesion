<?php

namespace Business\Actividades\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class EliminarMusculacionException extends BusinessException {

    protected $message = 'No se puede eliminar la actividad musculación';

}