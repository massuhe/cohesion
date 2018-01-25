<?php

namespace Business\Clases\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Clases\Helpers\SuspenderHelper;
use Business\Clases\Helpers\WeekHelper;

class ClaseHelper extends BaseHelper
{

    public function __construct(SuspenderHelper $sh, WeekHelper $wh)
    {
        $this->helpers = [$sh, $wh];
    }

}