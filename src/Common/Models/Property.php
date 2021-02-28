<?php

namespace App\MyProject\Common\Models;

use App\MyProject\Common\Traits\HasMultipleDataTypeFieldsTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Property extends Model
{

    use HasMultipleDataTypeFieldsTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'datatype', 'is_active',
        'value_string', 'value_bigint', 'value_float', 'value_boolean', 'value_json_array', 'value_json_object',
        'belongsToModel_type', 'belongsToModel_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'value_json_array' => 'array',
        'value_json_object' => 'object'
    ];

    /**
     * @return MorphTo
     */
    public function belongsToModel(): MorphTo
    {
        return $this->morphTo('belongsToModel');
    }

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return sprintf('%s.%s', $this->belongsToModel_type, $this->name);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $field = 'value_' . $this->datatype;
        return $this->$field;
    }

}
