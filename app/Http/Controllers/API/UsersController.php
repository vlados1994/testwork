<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class UsersController extends BaseController
{
    public function getAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = User::query();

        if($request->has('type')) {
            $query = $query->where(['type' => $request->type]);
        }

        $result = $query->get();

        return $this->sendResponse($result, '');
    }

    public function deleteUser($id): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            User::query()->where(['id' => $id])->delete(),
            'User deleted'
        );
    }
}
