<?php

namespace App\MyProject\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'package', 'action', 'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'mdi-security';
    }

}
