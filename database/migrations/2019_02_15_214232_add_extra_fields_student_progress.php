<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsStudentProgress extends Migration
{

    public function up()
    {
        Schema::table('student_progress', function (Blueprint $table) {
            $table->string('extra_fields', 30)->nullable();
        });
    }

    public function down()
    {
        Schema::table('student_progress', function (Blueprint $table) {
            $table->dropColumn(['extra_fields']);
        });
    }
}
