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
        Schema::create('club_associations', function (Blueprint $table) {
            $table->id();
            $table->string('club_name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Reference to users table
            $table->unsignedBigInteger('event_id')->nullable(); // Reference to events table
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_associations');
    }
};
