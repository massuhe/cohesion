<?php
namespace App\Http\Controllers;

use Optimus\Bruno\LaravelController;

class Controller extends LaravelController
{

    protected function badRequest($message = "Bad Request")
    {
        return response()->json($message, 400);
    }

    protected function internalError($message = "Internal Error")
    {
        return response()->json($message, 500);
    }

    protected function ok($content = '')
    {
        return response()->json($content, 200);
    }

    protected function okNoContent()
    {
        return response()->json('', 204);
    }

    protected function created($newObject)
    {
        return response()->json($newObject, 201);
    }

    protected function applySelect($data)
    {
        $only = request()->get('select');
        if(sizeOf($only) === 0){
            return $data;
        }
        $onlyParsed = $this->parseOnly($only);
        $keys = array_keys($onlyParsed);
        $subset = $data->map(function ($val) use ($keys, $onlyParsed) {
            $entity = collect($val->toArray())->only($keys);
            $this->algo($entity, $onlyParsed);
            return $entity;
        });
        return $subset;
    }

    protected function algo($data, $array)
    {
        $b = array_filter($array, function ($v) {
            return $v !== null;
        });
        foreach ($b as $c => $v) {
            $f2 = array_keys($v);
            $data[$c] = collect($data[$c])->only($f2);
            $this->algo($data[$c], $v);
        }
    }

    protected function parseOnly($only)
    {
        $return = [];
        foreach ($only as $k => $v) {
            if (!strpos($v, '.')) {
                $return[$v] = null;
            }
            else {
                $a = explode(".", $v, 2);
                $hue = $this->parseOnly(array_slice($a,1));
                foreach($hue as $k2 => $v2){
                    $return[$a[0]][$k2] = $v2;
                }
            }
        }
        return $return;
    }
}