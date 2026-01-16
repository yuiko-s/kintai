<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\BreakTime;
use App\Models\Attendance;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = BreakTime::class;
    public function definition(): array
    {   
        $attendance = Attendance::factory()->create();
        $break = $this->faker->dateTime();
        return [
            'attendance_id' => Attendance::factory(),
            'user_id'       => $attendance->user_id,
            'break_start' => $break,
            'break_end' => (clone $break)->modify('+1 hour')

        ];
    }
}
