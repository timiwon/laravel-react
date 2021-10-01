<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('businesses', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('type', 50);
      $table->string('status', 50);
      $table->string('name', 255);
      $table->string('address', 255);
      $table->string('phone', 100);
      $table->string('url', 255)->nullable();
      $table->uuid('customer_id');
      $table->foreign('customer_id')->references('id')->on('customers');
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
    Schema::dropIfExists('businesses');
  }
}
