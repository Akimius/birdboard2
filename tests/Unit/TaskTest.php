<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_a_task_belongs_to_a_project(): void
    {
        $task = Task::factory()->create();

        self::assertInstanceOf(Project::class, $task->project);
    }

    /**
     * @return void
     */
    public function test_it_has_a_path(): void
    {
        $task = Task::factory()->create();

        self::assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}
