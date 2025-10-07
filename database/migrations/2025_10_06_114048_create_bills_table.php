<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->foreignId('bill_category_id')->constrained()->onDelete('cascade');
            $table->string('month'); // Format: YYYY-MM
            $table->decimal('amount', 10, 2);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['flat_id', 'month']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};