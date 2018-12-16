<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDisciplinePlanTable extends Migration
{
    public function up()
    {
		Schema::table('discipline_plan', function(Blueprint $table) {
        $table->integer('discipline_id')->unsigned()->nullable()->change();
        
        $table->integer('studyplan_id')->unsigned()->nullable()->change();
        
        $table->renameColumn('start_semester', 'semester');
        
        $table->renameColumn('has_project', 'has_coursework');
        
        $table->boolean('has_course_project')->nullable();
        $table->boolean('has_design_assignment')->nullable();
        $table->boolean('has_essay')->nullable();
        $table->boolean('has_home_test')->nullable();
        $table->boolean('has_audience_test')->nullable();
        
        $table->renameColumn('hours', 'hours_all');
        $table->smallInteger('hours_lecture')->nullable();
        $table->smallInteger('hours_laboratory')->nullable();
        $table->smallInteger('hours_practical')->nullable();
        $table->smallInteger('hours_solo')->nullable();
        $table->smallInteger('count_lecture')->nullable();
        $table->smallInteger('count_laboratory')->nullable();
        $table->smallInteger('count_practical')->nullable();
    });
    }
    
    public function down()
    {
        Schema::table('discipline_plan', function(Blueprint $table) {
            $table->integer('discipline_id')->unsigned()->nullable(false)->change();
            $table->integer('studyplan_id')->unsigned()->nullable(false)->change();
            
            $table->renameColumn('semester', 'start_semester');
            
            $table->renameColumn('has_coursework', 'has_project');
            
            $table->dropColumn('has_course_project');
            $table->dropColumn('has_design_assignment');
            $table->dropColumn('has_essay');
            $table->dropColumn('has_home_test');
            $table->dropColumn('has_audience_test');
            
            $table->renameColumn('hours_all', 'hours');
            $table->dropColumn('hours_lecture');
            $table->dropColumn('hours_laboratory');
            $table->dropColumn('hours_practical');
            $table->dropColumn('hours_solo');
            $table->dropColumn('count_lecture');
            $table->dropColumn('count_laboratory');
            $table->dropColumn('count_practical');
        });
    }
}