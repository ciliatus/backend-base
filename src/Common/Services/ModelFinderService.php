<?php

namespace App\MyProject\Common;

use App\MyProject\Common\Exceptions\ModelNotFoundException;
use App\MyProject\Common\Models\Model;

class ModelFinderService
{

    /**
     * @param string $class
     * @param int $id
     * @param array $with
     * @return Model
     * @throws ModelNotFoundException
     */
    public static function findOrFail(string $class, int $id, array $with = []): Model
    {
        try {
            return $class::with($with)->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException($class, $id);
        }
    }

    /**
     * @param string $class
     * @param int $id
     * @param array $with
     * @return Model|null
     */
    public static function find(string $class, int $id, array $with = []): ?Model
    {
        return $class::with($with)->find($id);
    }

}
