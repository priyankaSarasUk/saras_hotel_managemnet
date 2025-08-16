<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Add user_id column (foreign key)
            $table->unsignedBigInteger('user_id')->after('id');

            // Define foreign key
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade'); // if user deleted, customers also deleted
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop foreign key and column when rolling back
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
