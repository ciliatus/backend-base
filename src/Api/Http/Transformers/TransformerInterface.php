<?php

namespace App\MyProject\Api\Http\Transformers;

use App\MyProject\Common\Models\Model;

interface TransformerInterface
{

    public function transform(Model $model): array;

}
