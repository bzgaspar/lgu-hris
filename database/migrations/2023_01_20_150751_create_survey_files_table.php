<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_details_id');
            $table->string('document');
            $table->timestamps();


            $table->foreign('answer_details_id')->references('id')->on('survey_answer_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_files');
    }
}
