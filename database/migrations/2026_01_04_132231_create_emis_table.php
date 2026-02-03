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
        Schema::create('emis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->constrained()->cascadeOnDelete(); // billing_id से link
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->integer('installments');
            $table->decimal('installment_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2);
            $table->date('next_due_date');
            $table->enum('status', ['pending','partially_paid','completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emis');
    }
};
