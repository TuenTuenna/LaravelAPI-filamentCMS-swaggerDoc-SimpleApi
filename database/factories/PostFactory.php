<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

//        $table->string('title');
//        $table->longText('content')->nullable();
//        $table->longText('image')->nullable();
//        $table->boolean('is_published')->default(false);

        return [
            'title' => $this->faker->unique()->sentence(4),
            'content' => $this->faker->realText(),
            'created_at' => $this->faker->
            dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->
            dateTimeBetween('-5 month', 'now')

        ];
    }
}
