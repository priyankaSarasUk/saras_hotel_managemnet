<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableAddNewFields extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('male')->default(1)->after('adults');
            $table->integer('female')->default(0)->after('male');
            $table->string('purpose')->nullable()->after('childs');
            $table->string('arrival_from')->nullable()->after('purpose');
            $table->string('vehicle_number')->nullable()->after('arrival_from');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['male', 'female', 'purpose', 'arrival_from', 'vehicle_number']);
        });
    }
}
