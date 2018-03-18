<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table', 30);
            $table->string('status', 2);
            $table->string('description', 100);
            $table->integer('created_by', 45)->nullable();
            $table->integer('updated_by', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_status');
    }
}
