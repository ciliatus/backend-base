<?php

namespace App\MyProject\Api\Traits;

use App\MyProject\Api\Http\Requests\Request;
use Illuminate\Http\JsonResponse;

trait UsesDefaultUpdateMethodTrait
{

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        return $this->_update($request, $id);
    }

}
