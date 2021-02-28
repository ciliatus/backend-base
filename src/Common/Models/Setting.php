<?php

namespace App\MyProject\Common\Models;

use App\MyProject\Common\Traits\HasMultipleDataTypeFieldsTrait;

class Setting extends Model
{

    use HasMultipleDataTypeFieldsTrait;

    /**
     * @var array
     */
    public ?array $transformable = [
        'name', 'value', 'is_active'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * @param string $name
     * @param null $default
     * @return float|int|bool|string|null
     */
    public static function get(string $name, $default = null)
    {
        return is_null($s = static::where('name', $name)->first()) ? $default : $s->value;
    }

}
