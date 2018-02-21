<?php

namespace Business\Shared\Controllers;

use App\Http\Controllers\Controller;
use Business\Shared\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{

    private $imageService;

    public function __construct(ImageService $is)
    {
        $this->middleware('cors');
        $this->middleware('auth:api');
        $this->middleware('jwt.refresh');
       $this->imageService = $is;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $inventarioId
     * @return \Illuminate\Http\Response
     */
    public function getImage($folder, $imageName)
    {
        $data = $this->imageService->getImage($folder, $imageName);
        $image = $data['image'];
        $type = $data['type'];
        $response = Response::make($image, 200);
        $response->header('Content-Type', $type);
        return $response;
    }

}