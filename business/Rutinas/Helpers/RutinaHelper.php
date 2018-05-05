<?php

namespace Business\Rutinas\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Rutinas\Helpers\RutinaUpdater;

class RutinaHelper extends BaseHelper {

    public function __construct(RutinaUpdater $ru)
    {
        $this->helpers = [$ru];
    }

}