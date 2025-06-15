<?php
namespace Modules\CustomerSales\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerSalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CustomerSales\Entities\CustomerSales::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'address' => $this->faker->streetAddress()
        ];
    }
}

