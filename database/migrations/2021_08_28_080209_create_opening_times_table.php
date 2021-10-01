<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningTimesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('opening_times', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('action', 50);
      $table->string('weekly_value', 20)->nullable();
      $table->date('from_date')->nullable();
      $table->date('to_date')->nullable();
      $table->time('from_time');
      $table->time('to_time');
      $table->text('note')->nullable();
      $table->uuid('area_id')->nullable();
      $table->uuid('business_id')->nullable();
      $table->foreign('area_id')->references('id')->on('areas');
      $table->foreign('business_id')->references('id')->on('businesses');
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
    Schema::dropIfExists('schedules');
  }
}
