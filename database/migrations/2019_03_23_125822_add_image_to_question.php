<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToQuestion extends Migration
{
    public function up()
    {
        Schema::table('question', function (Blueprint $table)
        {
            $table
                ->integer('image_id')
                ->unsigned()
                ->nullable();

            $table
                ->foreign('image_id')
                ->references('id')
                ->on('file')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropColumn('image_id');
        });
    }
}