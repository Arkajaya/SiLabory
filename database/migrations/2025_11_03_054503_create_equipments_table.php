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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_id')->constrained('laboratories')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->enum('condition', ['bagus', 'rusak ringan', 'rusak berat'])->default('bagus');
            $table->integer('quantity')->default(0);
            $table->integer('available_qty')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
