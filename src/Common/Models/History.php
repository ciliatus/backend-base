<?php

namespace App\MyProject\Common\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class History extends Model
{

    /**
     * @var array
     */
    public ?array $transformable = [
        'event', 'params'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'event', 'params', 'created_at'
    ];

    /**
     * @return MorphTo
     */
    public function belongsToModel(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return array
     */
    public function transform(): array
    {
        $params = explode('||', $this->params);
        $params = array_map(function ($param) {
            if (is_a($param, Model::class)) {
                $obj = explode('::', $param);
                $model = $obj[0]::find($obj[1]);
                if (is_null($model)) {
                    return $param;
                }

                return $model->transform();
            }

            return $param;
        }, $params);

        return [
            'id' => $this->id,
            'event' => $this->event,
            'params' => $params
        ];
    }

}
