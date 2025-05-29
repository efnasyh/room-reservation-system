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
        Schema::table('student_events', function (Blueprint $table) {
            // Only add column if it doesn't exist
            if (!Schema::hasColumn('student_events', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');

                // If you want to enforce foreign key constraint
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_events', function (Blueprint $table) {
            // Drop foreign key first if it exists
            if (Schema::hasColumn('student_events', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
