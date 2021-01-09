<?php

declare(strict_types=1);

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    /**
     * @var int
     */
    private int $taskCount = 0;

    /**
     * @var User
     */
    private User $user;

    public function withTasks(int $count): self
    {
        $this->taskCount = $count;

        return $this;
    }

    public function ownedBy(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Project
     */
    public function create(): Project
    {
        $project = Project::factory()->create(
            [
                'owner_id' => $this->user ?? User::factory()->create()->id
                //'owner_id' => User::factory() // Equal to above line
            ]
        );

        if ($this->taskCount) {
            Task::factory()->count($this->taskCount)->create(
                [
                    'project_id' => $project->id
                ]
            );
        }

        return $project;
    }

}