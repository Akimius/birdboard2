<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project']; // updates updated_at any relations belongsTo() or belongsToMany()

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class)->orderByDesc('updated_at');
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }

}
