<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeDeleteStudentProgress extends Migration
{
    public function up()
    {
        Schema::table('student_progress', function(Blueprint $table)
        {
            $table->dropForeign('student_progress_discipline_plan_id_foreign');
            $table->dropForeign('student_progress_student_id_foreign');

            $table->foreign('discipline_plan_id', 'student_progress_discipline_plan_id_foreign')->references('id')->on('discipline_plan')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('student_id', 'student_progress_student_id_foreign')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::table('student_progress', function(Blueprint $table)
        {
            $table->dropForeign('student_progress_discipline_plan_id_foreign');
            $table->dropForeign('student_progress_student_id_foreign');

            $table->foreign('discipline_plan_id', 'student_progress_discipline_plan_id_foreign')->references('id')->on('discipline_plan')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('student_id', 'student_progress_student_id_foreign')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
