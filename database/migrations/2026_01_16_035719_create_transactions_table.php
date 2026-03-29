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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('borrowed_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->date('due_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->enum('status', ['pending', 'borrowed', 'returned', 'late', 'rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
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
