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
            $table->foreignIdFor(User::class, 'payer_id')->nullable()->constrained('users');
            $table->foreignIdFor(User::class, 'payee_id')->nullable()->constrained('users');
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('type')->nullable(); // TransactionTypeEnum
            $table->string('status')->nullable(); // TransactionStatusEnum
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
