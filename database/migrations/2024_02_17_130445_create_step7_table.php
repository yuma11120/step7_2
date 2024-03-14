<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step7', function (Blueprint $table) {
            $table->id('ID');
            $table->bigInteger('picture');
            $table->bigInteger('name');
            $table->string('price');
            $table->string('stock');
            $table->string('makerName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step7');
    }
};
