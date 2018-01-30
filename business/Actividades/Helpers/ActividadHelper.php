<?php

namespace Business\Actividades\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Actividades\Helpers\DiasHelper;
use Business\Clases\Helpers\ClaseGeneratorHelper;

class ActividadHelper extends BaseHelper
{

    public function __construct(DiasHelper $dh, ClaseGeneratorHelper $cgh)
    {
        $this->helpers = [$dh, $cgh];
    }

}