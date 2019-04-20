<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToQuestion extends Migration
{
    public function up()
    {
        Schema::table('question', function (Blueprint $table)
        {
            $table
                ->integer('order')
                ->unsigned()
                ->nullable();
        });
    }

    public function down()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}