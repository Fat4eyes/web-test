<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionStudentTable extends Migration
{
    public function up()
    {
        Schema::create('question_student', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->boolean('passed');

            $table
                ->foreign('student_id')
                ->references('id')
                ->on('user')
                ->onDelete('cascade');

            $table
                ->foreign('question_id')
                ->references('id')
                ->on('question')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('question_student', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['question_id']);
        });

        Schema::drop('question_student');
    }
}