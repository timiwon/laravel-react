<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesHasBusinessesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('roles_has_businesses', function (Blueprint $table) {
      $table->uuid('role_id');
      $table->uuid('business_id');
      $table->foreign('role_id')->references('id')->on('roles')
                                                  ->onDelete('cascade');
      $table->foreign('business_id')->references('id')->on('businesses')
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
    Schema::dropIfExists('areas');
  }
}
