<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_it_has_a_path(): void
    {
        $task = Task::factory()->create();

        self::assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}
