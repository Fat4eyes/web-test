<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeReferenceConstraintInQuestionTable extends Migration
{
    public function up()
    {
        Schema::table('question', function (Blueprint $table)
        {
            $table->dropForeign(['theme_id']);

            $table
                ->foreign('theme_id')
                ->references('id')
                ->on('theme')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('question', function (Blueprint $table)
        {
            $table->dropForeign(['theme_id']);

            $table
                ->foreign('theme_id')
                ->references('id')
                ->on('theme')
                ->onDelete('restrict');
        });
    }
}