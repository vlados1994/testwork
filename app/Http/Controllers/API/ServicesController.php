<?php

namespace App\Http\Controllers\API;

use App\Models\Service;
use App\Http\Controllers\API\BaseController as BaseController;

class ServicesController extends BaseController
{
    public function getAll(): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(Service::query()->get(), 'ok');
    }
}
