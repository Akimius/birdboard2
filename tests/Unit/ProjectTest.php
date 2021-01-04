<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_a_project_knows_its_path(): void
    {
        $this->actingAs(User::factory()->create());
        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        self::assertEquals($project->path(), '/projects/' . $project->id);
    }

    /**
     * @return void
     */
    public function test_belongs_to_an_owner(): void
    {
        $project = Project::factory()->create();

        self::assertInstanceOf(User::class, $project->owner);
    }

    /**
     * @return void
     */
    public function test_can_add_a_task(): void
    {
        $project = Project::factory()->create();
        $task    = $project->addTask('Test task');

        self::assertCount(1, $project->tasks);

        self::assertTrue($project->tasks->contains($task));
    }
}
