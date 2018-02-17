<?php

namespace Business\Actividades\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Actividades\Helpers\DiasHelper;
use Business\Clases\Helpers\ClasesGenerator;
use Business\Clases\Helpers\ClasesEspecificasGenerator;

class ActividadHelper extends BaseHelper
{

    public function __construct(DiasHelper $dh, ClasesGenerator $cg, ClasesEspecificasGenerator $ceg)
    {
        $this->helpers = [$dh, $cg, $ceg];
    }

}