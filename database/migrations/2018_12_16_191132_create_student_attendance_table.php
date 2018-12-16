<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAttendanceTable extends Migration
{
    public function up()
    {
        Schema::create('student_attendance', function(Blueprint $table)
        {
            $table->integer('id', true);
            $table->integer('discipline_group_id')->nullable()->index('student_attendance_discipline_group_id_foreign');
            $table->integer('student_id')->unsigned()->nullable()->index('student_attendance_student_id_foreign');
            $table->string('occupation_type', 50)->nullable();
            $table->smallInteger('occupation_number')->nullable();
            $table->string('visit_status', 15)->nullable();
        });
    
        Schema::table('student_attendance', function(Blueprint $table)
        {
            $table->foreign('discipline_group_id', 'student_attendance_discipline_group_id_foreign')->references('id')->on('discipline_group')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('student_id', 'student_attendance_student_id_foreign')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
    
    public function down()
    {
        Schema::table('student_attendance', function(Blueprint $table)
        {
            $table->dropForeign('student_attendance_discipline_group_id_foreign');
            $table->dropForeign('student_attendance_student_id_foreign');
        });
        
        Schema::drop('student_attendance');
    }
}
