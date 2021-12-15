<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tutorial_request_id');
            $table->foreign('tutorial_request_id')->references('id')->on('tutorial_requests');
            $table->text('description');
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
        Schema::dropIfExists('tutor_comments');
    }
}
