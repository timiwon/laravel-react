<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('first_name', 255);
      $table->string('last_name', 255);
      $table->string('avatar', 255)->nullable();
      $table->string('email', 255)->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password', 255);
      $table->string('phone', 100)->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}
