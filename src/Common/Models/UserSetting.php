<?php

namespace App\MyProject\Common\Models;

use App\MyProject\Common\Traits\HasMultipleDataTypeFieldsTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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
