<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerToMaterial extends Migration
{
    public function up()
    {
        Schema::table('material', function (Blueprint $table)
        {
            $table
                ->integer('owner_id')
                ->unsigned();

            $table
                ->foreign('owner_id')
                ->references('id')
                ->on('user')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('material', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });
    }
}
