<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_name');
            $table->string('matric_no');
            $table->string('position');
            $table->string('phone_no');
            $table->string('advisor_name');
            $table->string('email');
            $table->string('program_name');
            $table->string('club_name');
            $table->string('location');
            $table->date('date');
            $table->integer('allocation_requested');
            $table->integer('participants');
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->string('paperwork');// Path to uploaded paperwork
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
