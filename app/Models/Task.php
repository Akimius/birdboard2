<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return string
     */
    public function path(): string
    {
        // TODO
        return '/tasks/' . $this->id;
    }
}
