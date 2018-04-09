<?php

namespace Business\Shared\Exceptions;

use Business\Shared\Exceptions\BusinessException;

class EmailTemplateNotFound extends BusinessException {

    protected $message;

    public function __construct($tn)
    {
        $this->message = "No se encontró el template '$tn'";
    }


}