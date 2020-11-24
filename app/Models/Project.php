<?php

namespace App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;

class Project extends BaseModel
{
    public function path()
    {
        return '/projects/' . $this->id;
    }
}
