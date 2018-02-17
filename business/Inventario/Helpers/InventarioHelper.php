<?php

namespace Business\Inventario\Helpers;

use Business\Shared\Helpers\ImageHelper;
use Business\Shared\Helpers\BaseHelper;

class InventarioHelper extends BaseHelper
{

    public function __construct(ImageHelper $ih)
    {
        $this->helpers = [$ih];
    }

}