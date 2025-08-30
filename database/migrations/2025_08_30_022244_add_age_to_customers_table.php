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
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('email');           // Add age
            $table->string('nationality')->nullable()->after('age');      // Add nationality
            $table->string('occupation')->nullable()->after('nationality'); // Add occupation
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['age', 'nationality', 'occupation']); // Remove added columns
        });
    }
};
