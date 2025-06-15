<?php

namespace Modules\ItemClarity\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemClarityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\ItemClarity\Models\ItemClarity::class;

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
