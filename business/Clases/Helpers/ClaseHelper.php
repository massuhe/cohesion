<?php

namespace Business\Clases\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Clases\Helpers\SuspenderHelper;
use Business\Clases\Helpers\WeekHelper;
use Business\Clases\Helpers\ClasesGenerator;

class ClaseHelper extends BaseHelper
{

    public function __construct(SuspenderHelper $sh, WeekHelper $wh, ClasesGenerator $cg)
    {
        $this->helpers = [$sh, $wh, $cg];
    }

}