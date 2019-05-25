<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialAnchorTable extends Migration
{
    public function up()
    {
        Schema::create('material_anchor', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('material_id')->unsigned();
            $table->string('token');
            $table->string('name');

            $table
                ->foreign('material_id')
                ->references('id')
                ->on('material')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('material_anchor', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
        });

        Schema::drop('material_anchor');
    }
}