<?php

namespace Database\Factories;

use App\Enums\Types;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->name;
        return [
            'name' => $name,
            'code' => str($name)->slug(),
            'type' => Types::COMPANY
        ];
    }
}
