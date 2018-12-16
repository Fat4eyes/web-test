<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplineGroup extends Migration
{
    public function up()
    {
        Schema::create('discipline_group', function(Blueprint $table)
        {
            $table->integer('id', true);
            $table->integer('group_id')->unsigned()->nullable()->index('discipline_group_group_id_foreign');
            $table->integer('discipline_plan_id')->unsigned()->nullable()->index('discipline_group_discipline_plan_id_foreign');
            $table->integer('studyplan_id')->unsigned()->nullable()->index('discipline_group_studyplan_id_foreign');
        });
    
        Schema::table('discipline_group', function(Blueprint $table)
        {
            $table->foreign('discipline_plan_id')->references('id')->on('discipline_plan')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('group_id')->references('id')->on('group')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('studyplan_id')->references('id')->on('studyplan')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
    
    public function down()
    {
        Schema::table('discipline_group', function(Blueprint $table)
        {
            $table->dropForeign('discipline_group_discipline_plan_id_foreign');
            $table->dropForeign('discipline_group_group_id_foreign');
            $table->dropForeign('discipline_group_studyplan_id_foreign');
        });
        
        Schema::drop('discipline_group');
    }
}
