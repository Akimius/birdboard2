<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends BaseModel
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'owner_id' => 'int',
    ];

    /**
     * @return string
     */
    public function path(): string
    {
        return '/projects/' . $this->id;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
