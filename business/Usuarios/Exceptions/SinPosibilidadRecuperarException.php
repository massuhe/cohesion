<?php

namespace Business\Usuarios\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class SinPosibilidadRecuperarException extends BusinessException{

    protected $message = 'No cuentas con clases para recuperar';

}