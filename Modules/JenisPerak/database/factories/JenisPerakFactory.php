<?php

namespace Modules\JenisPerak\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JenisPerakFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\JenisPerak\Models\JenisPerak::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => substr($this->faker->text(15), 0, -1),
            'description'       => $this->faker->paragraph,
             'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
