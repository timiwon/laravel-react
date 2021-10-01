<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bookings', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('status', 50);
      $table->date('booking_date');
      $table->time('booking_time');
      $table->integer('guests_number');
      $table->time('duration');
      $table->integer('prepayment_amount')->nullable();
      $table->string('cus_fb_id', 255)->nullable();
      $table->string('cus_email', 255);
      $table->string('cus_name', 255);
      $table->string('cus_phone', 100)->nullable();
      $table->string('transaction_id', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('bookings');
  }
}
