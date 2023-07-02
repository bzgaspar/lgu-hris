<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplicationPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_application_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_app_id');
            $table->float('vl_earned', 50, 3)->nullable();
            $table->float('sl_earned', 50, 3)->nullable();
            $table->float('vl_leave', 50, 3)->nullable();
            $table->float('sl_leave', 50, 3)->nullable();
            $table->float('vl_new_balance', 50, 3)->nullable();
            $table->float('sl_new_balance', 50, 3)->nullable();
            $table->timestamps();

            $table->foreign('leave_app_id')->references('id')->on('leave_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_application_points');
    }
}
