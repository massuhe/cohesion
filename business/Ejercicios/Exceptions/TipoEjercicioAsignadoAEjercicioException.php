<?php

namespace Business\Ejercicios\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class TipoEjercicioAsignadoAEjercicioException extends BusinessException {

    protected $message = 'El tipo de ejercicio no se puede eliminar ya que está asociado a uno o más ejercicios';

}