<?php

namespace Business\Shared\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class ImageNotFoundException extends BusinessException {

    protected $message;

    public function __construct()
    {
        $this->message = "No se ha encontrado la imagen";
    }

}