<?php

namespace Database\Factories;

use App\Models\Approval;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approval>
 */
class ApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'attendance_id' => Attendance::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved']),
            'remarks' => $this->faker->sentence(''),
        ];
    }

    public function pending()
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function approved()
    {
        return $this->state(fn () => ['status' => 'approved']);
    }
}
