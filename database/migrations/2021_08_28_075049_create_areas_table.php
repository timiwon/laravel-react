<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('areas', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('status', 50);
      $table->string('name', 255);
      $table->integer('priority')->default(0);
      $table->uuid('business_id');
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
    Schema::dropIfExists('areas');
  }
}
