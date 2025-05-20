<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'payer_id')->constrained('users');
            $table->foreignIdFor(User::class, 'payee_id')->constrained('users');
            $table->dateTime('date');
            $table->decimal('amount', 12, 2);
            $table->string('type'); // TransactionTypeEnum
            $table->string('status'); // TransactionStatusEnum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
