<?php

namespace Database\Factories;

use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(TransactionTypeEnum::cases());
        $payer = $type == TransactionTypeEnum::DEPOSIT ? $payerId = null : $payerId = User::factory();

        return [
            'payer_id' => $payer,
            'payee_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 1, 1000),
            'date' => fake()->dateTime(),
            'type' =>   fake()->randomElement(TransactionTypeEnum::cases()),
            'status' => fake()->randomElement(TransactionStatusEnum::cases()),
        ];
    }
}
