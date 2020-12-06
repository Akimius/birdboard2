<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_guests_cannot_create_projects(): void
    {
        $attributes = Project::factory()->make()->toArray();

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    public function test_guests_may_not_view_projects(): void
    {
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
    }

    public function test_guests_cannot_view_a_single_project(): void
    {
        $project = Project::factory()->make();

        $this->get($project->path())->assertRedirect('login');
    }

    public function test_a_user_can_create_a_project(): void
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create());

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title'        => $this->faker->sentence,
            'description'  => $this->faker->paragraph,
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_an_authenticated_user_cannot_view_the_projects_of_others(): void
    {
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }


    public function test_a_project_requires_a_title(): void
    {
        $this->actingAs(User::factory()->create());
        $attributes = Project::factory()->make(['title' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description(): void
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->make(['description' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_their_project(): void
    {
        $this->actingAs(User::factory()->create());
        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
}
