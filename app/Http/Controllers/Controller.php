<?php

namespace App\Http\Controllers;

use Optimus\Bruno\LaravelController;

class Controller extends LaravelController
{

    protected function badRequest($message = "Bad Request") {
        return response()->json($message, 400);
    }

    protected function internalError($message = "Internal Error") {
        return response()->json($message, 500);
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
