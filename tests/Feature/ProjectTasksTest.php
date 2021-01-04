<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @returns void
     */
    public function test_a_project_can_have_tasks(): void
    {
        //$this->withoutExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    /**
     * @returns void
     */
    public function test_a_task_can_be_updated(): void
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $task = $project->addTask('Some task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
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

        $project = Project::factory()->create();

        $task = $project->addTask('some task');

        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /**
     * @returns void
     */
    public function test_a_task_requires_a_body(): void
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
