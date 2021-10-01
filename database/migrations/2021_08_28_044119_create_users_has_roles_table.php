<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersHasRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users_has_roles', function (Blueprint $table) {
      $table->uuid('user_id');
      $table->uuid('role_id');
      $table->foreign('user_id')->references('id')->on('users')
                                                  ->onDelete('cascade');
      $table->foreign('role_id')->references('id')->on('roles')
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
    Schema::dropIfExists('users_has_roles');
  }
}
