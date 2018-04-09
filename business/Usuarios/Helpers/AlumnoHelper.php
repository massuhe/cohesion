<?php

namespace Business\Usuarios\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Finanzas\Helpers\CuotaFormatter;
use Business\Usuarios\Helpers\FrecuenciaBasedBehaviors;

class AlumnoHelper extends BaseHelper {

    public function __construct(CuotaFormatter $cf, FrecuenciaBasedBehaviors $fh)
    {
        $this->helpers = [$cf, $fh];
    }

}