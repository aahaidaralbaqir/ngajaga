<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
	protected $model = Payment::class;
    public function definition()
    {
        return [
            //
        ];
    }
}
