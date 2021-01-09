<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     *
     */
    public function test_guests_cannot_create_projects(): void
    {
        $attributes = Project::factory()->make()->toArray();

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /**
     *
     */
    public function test_guests_may_not_view_projects(): void
    {
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
    }

    /**
     *
     */
    public function test_guests_cannot_view_a_single_project(): void
    {
        $project = Project::factory()->make();

        $this->get($project->path())->assertRedirect('login');
    }

    /**
     *
     */
    public function test_a_user_can_create_a_project(): void
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title'        => $this->faker->sentence,
            'description'  => $this->faker->sentence,
            'notes'        => $this->faker->paragraph,
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee((new Project())->getDescription($attributes['description']))
            ->assertSee($attributes['notes']);
    }

    /**
     *
     */
    public function test_a_user_can_update_a_project(): void
    {
        $project = app(ProjectFactory::class)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->path(), [
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    /**
     *
     */
    public function test_an_authenticated_user_cannot_view_the_projects_of_others(): void
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /**
     *
     */
    public function test_an_authenticated_user_cannot_update_the_projects_of_others(): void
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path(), [])->assertStatus(403);
    }


    /**
     *
     */
    public function test_a_project_requires_a_title(): void
    {
        $this->signIn();

        $attributes = Project::factory()->make(['title' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     *
     */
    public function test_a_project_requires_a_description(): void
    {
        $this->signIn();

        $attributes = Project::factory()->make(['description' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /**
     *
     */
    public function test_a_user_can_view_their_project(): void
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->getTitle())
            ->assertSee($project->getDescription());
    }
}
