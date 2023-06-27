<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlyIPCRSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearly_i_p_c_r_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dep_id');
            $table->string('year');
            $table->string('add_points');
            $table->string('total');
            $table->timestamps();

            $table->foreign('dep_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearly_i_p_c_r_s');
    }
}
