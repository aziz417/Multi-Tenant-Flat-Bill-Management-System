<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->string('flat_number');
            $table->integer('floor_number');
            $table->string('flat_owner_name');
            $table->string('flat_owner_phone', 20)->nullable();
            $table->string('flat_owner_email')->nullable();
            $table->integer('bedrooms')->default(1);
            $table->decimal('monthly_rent', 10, 2)->nullable();
            $table->enum('status', ['occupied', 'vacant'])->default('vacant');
            $table->timestamps();

            $table->unique(['building_id', 'flat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};