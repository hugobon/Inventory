<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_tax', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->string('code')->unique()->comment('Example: GST');
			$table->integer('percent')->comment('Percent tax: 6 %')->default('0');
			$table->string('remarks')->default('');
			$table->integer('created_by')->comment('User ID')->nullable();
			$table->datetime('created_at');
			$table->integer('updated_by')->comment('User ID')->nullable();
			$table->datetime('updated_at');
        });
		
		// Insert Tax GST 
		DB::table('config_tax')->insert(
			array(
				'code' => 'gst',
				'percent' => 6,
				'remarks' => 'default : 6%',
				'created_by' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_by' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			)
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax');
    }
}
