<?php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'transaction_id', length: 32)->unique();
            $table->string(column: 'payment_reference', length: 12)->nullable();
            $table->decimal(column: 'amount', total: 10, places: 2)->nullable();
            $table->decimal(column: 'charged_amount', total: 10, places: 2)->nullable();
            $table->string(column: 'first_name', length: 20)->nullable();
            $table->string(column: 'last_name', length: 20)->nullable();
            $table->string(column: 'email', length: 100)->nullable();
            $table->string(column: 'purpose', length: 100)->nullable();
            $table->string(column: 'payment_status', length: 10)
                ->default(App\Enums\PaymentStatus::PENDING->value);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
