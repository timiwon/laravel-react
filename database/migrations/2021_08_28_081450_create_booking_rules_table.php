<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRulesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('booking_rules', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->integer('max_bookings');
      $table->integer('max_bookings_interval');
      $table->integer('max_guests');
      $table->integer('max_guests_interval');
      $table->boolean('is_count_online');
      $table->time('time_interval');
      $table->time('duration');
      $table->string('prepayment', 50);
      $table->integer('prepayment_amount')->nullable();
      $table->integer('prepayment_min_guest')->nullable();
      $table->integer('cancel_before')->nullable();
      $table->integer('maximum_lead_time');
      $table->integer('minimum_lead_time');
      $table->uuid('opening_time_id');
      $table->foreign('opening_time_id')->references('id')->on('opening_times');
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
    Schema::dropIfExists('booking_rules');
  }
}
