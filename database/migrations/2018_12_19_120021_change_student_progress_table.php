<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStudentProgressTable extends Migration
{
    public function up()
    {
        Schema::table('student_progress', function (Blueprint $table) {
            $table->dropForeign('student_progress_discipline_group_id_foreign');
            $table->integer('discipline_plan_id')->unsigned()->nullable()->index('student_progress_discipline_plan_id_foreign');
            $table->dropColumn('discipline_group_id');
        });

        Schema::table('student_progress', function (Blueprint $table) {
            $table->foreign('discipline_plan_id', 'student_progress_discipline_plan_id_foreign')
                ->references('id')->on('discipline_plan')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table('student_progress', function (Blueprint $table) {
            $table->integer('discipline_group_id')->nullable()->index('student_attendance_discipline_group_id_foreign');
            $table->dropForeign('student_progress_discipline_plan_id_foreign');
            $table->dropColumn('discipline_plan_id');
        });

        Schema::table('student_progress', function (Blueprint $table) {

            $table->foreign('discipline_group_id', 'student_progress_discipline_group_id_foreign')->references('id')->on('discipline_group')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
