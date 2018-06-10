<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigQuantitytypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_quantitytype', function (Blueprint $table) {
            $table->increments('id');
			$table->string('type')->comment('Quantity Type');
			$table->longText('remarks');
			$table->integer('status')->comment('0: inactive, 1: active')->default('1');
			$table->integer('created_by')->comment('User ID')->nullable();
			$table->integer('updated_by')->comment('User ID')->nullable();
            $table->timestamps();
        });
		
		// Insert some Quantity Type
		$data = array(
			'type' => 'BOX',
			'remarks' => 'Kotak',
			'status' => '1',
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		DB::table('config_quantitytype')->insert($data);
		
		$data['type'] = 'UNIT';
		$data['remarks'] = 'Unit';
		DB::table('config_quantitytype')->insert($data);
		
		$data['type'] = 'BTL';
		$data['remarks'] = 'Bottle';
		DB::table('config_quantitytype')->insert($data);
		
		$data['type'] = 'PC';
		$data['remarks'] = 'Leaflet';
		DB::table('config_quantitytype')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_quantitytype');
    }
}
