<?php

namespace Business\Shared\Helpers;

class BaseHelper {

    protected $helpers;

    public function __call($method, $args)
    {
        forEach($this->helpers as $helper) {
            if(method_exists($helper, $method)){
                return call_user_func_array([$helper, $method], $args);
            }
        }
        throw new \Exception("El método $method no existe");
    }

}