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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Delete all user blogs if user is deleted
            $table->string('title')->index(); // Index for faster searches
            $table->text('content');
            $table->string('slug')->unique(); // Ensure uniqueness
            $table->dateTime('published_at')->nullable()->index(); // Supports future scheduling
            $table->boolean('status')->default(false)->index(); // false = draft, true = published
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
