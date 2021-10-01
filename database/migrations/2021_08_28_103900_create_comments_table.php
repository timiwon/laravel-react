<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('comments', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('status', 50);
      $table->text('content');
      $table->uuid('user_id')->nullable();
      $table->uuid('booking_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('booking_id')->references('id')->on('bookings');
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
    Schema::dropIfExists('comments');
  }
}
