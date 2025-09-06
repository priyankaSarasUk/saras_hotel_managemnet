<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->integer('members')->default(1);
            $table->integer('adults')->default(1);
            $table->integer('childs')->default(0);
            $table->decimal('amount', 10, 2);
            $table->string('id_front')->nullable(); // store front ID file path
            $table->string('id_back')->nullable();  // store back ID file path
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
