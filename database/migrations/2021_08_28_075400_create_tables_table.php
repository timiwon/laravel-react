<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tables', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('status', 50);
      $table->boolean('is_available_online');
      $table->string('type', 50);
      $table->string('name', 255);
      $table->integer('priority')->default(0);
      $table->integer('min_guests');
      $table->integer('max_guests');
      $table->uuid('area_id');
      $table->foreign('area_id')->references('id')->on('areas');
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
    Schema::dropIfExists('tables');
  }
}
