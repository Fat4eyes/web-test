<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->increments('id');
            $table->guid('guid');
            $table->string('name');
            $table->smallInteger('type');
        });
    }

    public function down()
    {
        Schema::drop('file');
    }
}
