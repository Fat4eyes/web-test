<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialTable extends Migration
{
    public function up()
    {
        Schema::create('material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('template');
        });
    }

    public function down()
    {
        Schema::drop('material');
    }
}