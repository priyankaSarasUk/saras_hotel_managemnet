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
        Schema::table('users', function (Blueprint $table) {
            // Add phone column
            $table->string('phone', 20)->nullable()->after('email'); // Example: varchar(20), nullable, after 'email'

            // Add address column
            $table->string('address', 500)->nullable()->after('phone'); // Example: varchar(500), nullable, after 'phone'

            // Add created_by column (assuming it's a foreign ID referencing users table itself)
            // This assumes `created_by` refers to another user's ID
            $table->foreignId('created_by')
                  ->nullable() // It can be null if not set (e.g., for initial registrations)
                  ->constrained('users') // References the 'id' column on the 'users' table
                  ->onDelete('set null') // If the referenced user is deleted, set this to null
                  ->after('password'); // Position it after 'password'

            // If 'created_by' is just an integer and NOT a foreign key reference:
            // $table->unsignedBigInteger('created_by')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraint first if applicable
            $table->dropForeign(['created_by']);
            // Drop the columns
            $table->dropColumn(['phone', 'address', 'created_by']);
        });
    }
};