<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStudyplanTable extends Migration
{
    public function up()
    {
        Schema::table('studyplan', function(Blueprint $table) {
            $table->integer('year')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('studyplan', function(Blueprint $table) {
            $table->dropColumn('year');
        });
    }
}
