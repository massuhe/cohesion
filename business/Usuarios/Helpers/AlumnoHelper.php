<?php

namespace Business\Usuarios\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Finanzas\Helpers\CuotaFormatter;

class AlumnoHelper extends BaseHelper {

    public function __construct(CuotaFormatter $cf)
    {
        $this->helpers = [$cf];
    }

}