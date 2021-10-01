<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesHasPermissionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('roles_has_permissions', function (Blueprint $table) {
      $table->uuid('role_id');
      $table->uuid('permission_id');
      $table->foreign('role_id')->references('id')->on('roles')
                                                  ->onDelete('cascade');
      $table->foreign('permission_id')->references('id')->on('permissions')
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
    Schema::dropIfExists('roles_has_permissions');
  }
}
