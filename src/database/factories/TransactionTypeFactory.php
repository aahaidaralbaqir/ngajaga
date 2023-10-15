<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TransactionType;

class TransactionTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
	protected $model = TransactionType::class;
    public function definition()
    {
        return [
            //
        ];
    }
}
