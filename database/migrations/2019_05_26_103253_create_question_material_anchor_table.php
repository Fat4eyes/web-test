<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionMaterialAnchorTable extends Migration
{
    public function up()
    {
        Schema::create('question_material_anchor', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('material_anchor_id')->unsigned();

            $table
                ->foreign('question_id')
                ->references('id')
                ->on('question')
                ->onDelete('cascade');

            $table
                ->foreign('material_anchor_id')
                ->references('id')
                ->on('material_anchor')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('question_material_anchor', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->dropForeign(['material_anchor_id']);
        });

        Schema::drop('question_material_anchor');
    }
}