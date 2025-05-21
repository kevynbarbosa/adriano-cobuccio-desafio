<?php

use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('user can make a deposit', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/deposits/store', [
        'amount' => 100.00,
    ]);

    $this->assertDatabaseHas('transactions', [
        'payee_id' => $user->id,
        'amount' => 100.00,
    ]);
});

test('deposit fails with invalid amount', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/deposits/store', [
        'amount' => -50,
    ]);

    $response->assertStatus(422);
});

test('unauthenticated user cannot deposit', function () {
    $response = $this->postJson('/deposits/store', [
        'amount' => 100.00,
    ]);

    $response->assertStatus(401);
});

test('user can refund a deposit', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $transaction = Transaction::factory()->create([
        'payee_id' => $user->id,
        'amount' => 100.00,
        'type' => TransactionTypeEnum::DEPOSIT,
    ]);

    $response = $this->postJson("/deposits/$transaction->id/undo");

    $response->assertStatus(302);

    $updatedTransaction = Transaction::find($transaction->id);
    $this->assertEquals(TransactionStatusEnum::REFUNDED, TransactionStatusEnum::from($updatedTransaction->status));
});

test('unauthenticated user cannot refund deposit', function () {

    $transaction = Transaction::factory()->create([
        'payee_id' => User::factory()->create()->id,
        'amount' => 100.00,
        'type' => TransactionTypeEnum::DEPOSIT,
    ]);

    $response = $this->postJson("/deposits/$transaction->id/undo");

    $response->assertStatus(401);
});
