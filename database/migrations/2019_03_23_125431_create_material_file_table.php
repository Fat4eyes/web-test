<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialFileTable extends Migration
{
    public function up()
    {
        Schema::create('material_file', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('material_id')->unsigned();
            $table->integer('file_id')->unsigned();

            $table
                ->foreign('material_id')
                ->references('id')
                ->on('material')
                ->onDelete('cascade');

            $table
                ->foreign('file_id')
                ->references('id')
                ->on('file')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('material_file', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
            $table->dropForeign(['file_id']);
        });

        Schema::drop('material_file');
    }
}