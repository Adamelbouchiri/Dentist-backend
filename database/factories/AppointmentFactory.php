<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random date within the next year
        $date = $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d');
        
        // Generate a random time during working hours (8am-5pm)
        $time = $this->faker->time('H:i', rand(28800, 61200)); // 8am-5pm in seconds
        
        // Common medical services
        $services = [
            'General Checkup', 'Dental Cleaning', 'Eye Examination', 
            'Vaccination', 'Physical Therapy', 'Blood Test',
            'X-Ray', 'Ultrasound', 'ECG', 'MRI Scan'
        ];
        
        // Common doctor names
        $doctors = [
            'Dr. Smith', 'Dr. Johnson', 'Dr. Williams', 
            'Dr. Brown', 'Dr. Jones', 'Dr. Garcia',
            'Dr. Miller', 'Dr. Davis', 'Dr. Rodriguez'
        ];
        
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'service' => $this->faker->randomElement($services),
            'price' => $this->faker->numberBetween(50, 500),
            'doctor' => $this->faker->randomElement($doctors),
            'date' => $date,
            'time' => $time,
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['paid', 'unpaid', 'partial']),
        ];
    }
}
