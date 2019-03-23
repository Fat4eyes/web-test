<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaterialToQuestion extends Migration
{
    public function up()
    {
        Schema::table('question', function (Blueprint $table)
        {
            $table
                ->integer('material_id')
                ->unsigned()
                ->nullable();

            $table
                ->foreign('material_id')
                ->references('id')
                ->on('material')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
            $table->dropColumn('material_id');
        });
    }
}