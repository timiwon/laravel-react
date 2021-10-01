<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesHasBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables_has_bookings', function (Blueprint $table) {
            $table->uuid('table_id');
            $table->uuid('booking_id');
            $table->foreign('table_id')->references('id')->on('tables')
                ->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')
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
        Schema::dropIfExists('tables_has_bookings');
    }
}
