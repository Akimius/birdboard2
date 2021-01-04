<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @param string|null $title
     * @return string
     */
    public function getTitle(string $title = null): string
    {
        return Str::of($title ?: $this->title)->words(3, ' ...');
    }

    /**
     * @param string|null $description
     * @return string
     */
    public function getDescription(string $description = null): string
    {
        return Str::of($description ?: $this->description)->words(15, ' ...');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @param string $body
     * @return Model
     */
    public function addTask(string $body): Model
    {
        return $this->tasks()->create(['body' => $body]);
    }
}
