<?php

namespace Business\Clases\Helpers;

use Business\Shared\Helpers\BaseHelper;


class ClaseEspecificaHelper extends BaseHelper
{

    public function __construct(FormatHelper $fh, WeekHelper $wh) 
    {
        $this->helpers = [$fh, $wh];
    }

}