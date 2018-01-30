<?php
namespace App\Http\Controllers;

use Optimus\Bruno\LaravelController;
use Illuminate\Support\Facades\Gate;

class Controller extends LaravelController
{

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

    protected function forbidden()
    {
        return response()->json(['clientMessage' => 'No cuenta con los permisos suficientes para ejecutar la acción'], 403, ['Authorization']);
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
            if(!array_key_exists($f2[0], $data[$c])){
                $data[$c] = collect($data[$c])->map(function($d) use ($f2) {return collect($d)->only($f2);});
            } else {
                $data[$c] = collect($data[$c])->only($f2);
            }
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

    protected function tiene_permiso($permiso)
    {
        return Gate::allows('tiene-permiso', $permiso);
    }
}