<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function badRequest($message = "Bad Request") {
        return response()->json($message, 400);
    }

    protected function ok($content = '') {
        return response()->json($content, 200);
    }

    protected function okNoContent() {
        return response()->json('',204);
    }

    protected function created($newObject) {
        return response()->json($newObject, 201);
    }
}
