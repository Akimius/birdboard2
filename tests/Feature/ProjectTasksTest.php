<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @returns void
     */
    public function test_a_project_can_have_tasks(): void
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
             ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    /**
     * @returns void
     */
    public function test_a_task_can_be_updated(): void
    {
        $project = app(ProjectFactory::class)
            //->ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body'      => 'changed body',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body'      => 'changed body',
            'completed' => true,
        ]);
    }

    /**
     * @returns void
     */
    public function test_only_the_owner_of_a_project_may_add_tasks(): void
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test body'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test body']);
    }

    /**
     * @returns void
     */
    public function test_only_the_owner_of_a_project_may_update_a_task(): void
    {
        $this->signIn();

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /**
     * @returns void
     */
    public function test_a_task_requires_a_body(): void
    {
        $project = app(ProjectFactory::class)
            ->create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
