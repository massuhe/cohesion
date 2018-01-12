<?php

namespace Business\Clases\Helpers;

use Business\Shared\Helpers\BaseHelper;
use Business\Clases\Helpers\SuspenderHelper;

class ClaseHelper extends BaseHelper
{

    public function __construct(SuspenderHelper $sh) 
    {
        $this->helpers = [$sh];
    }

}