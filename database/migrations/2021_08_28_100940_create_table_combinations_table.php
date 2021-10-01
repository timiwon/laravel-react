<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCombinationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('table_combinations', function (Blueprint $table) {
      $table->uuid('table_id');
      $table->uuid('combined_table_id');
      $table->foreign('table_id')->references('id')->on('tables')
                                                   ->onDelete('cascade');
      $table->foreign('combined_table_id')->references('id')->on('tables')
                                                            ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('table_combinations');
  }
}
