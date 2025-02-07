<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project; // Import Project model
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $projectIds = Project::pluck('id')->toArray();

        return [
            'name' => $this->faker->sentence(),
            'priority' => $this->faker->numberBetween(1, 5),
            'project_id' => $this->faker->randomElement($projectIds),
        ];
    }
}
