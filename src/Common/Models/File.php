<?php

namespace App\MyProject\Common\Models;

use App\MyProject\Common\Traits\HasMultipleDataTypeFieldsTrait;

class File extends Model
{

    use HasMultipleDataTypeFieldsTrait;

    /**
     * @var array
     */
    public ?array $transformable = [
        'name', 'mime', 'type', 'public_path'
    ];

    /**
     * @param string $value
     * @return string
     */
    public function getPublicPathAttribute(string $value): string
    {
        return $this->self() . '/display';
    }

}
