<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigStockadjustmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_stockadjustment', function (Blueprint $table) {
            $table->increments('id')->unique();
			$table->string('adjustment')->comment('Stock Adjustment');
			$table->longText('remarks');
			$table->integer('status')->comment('0: inactive, 1: active')->default('1');
			$table->integer('created_by')->comment('User ID')->nullable();
			$table->datetime('created_at');
			$table->integer('updated_by')->comment('User ID')->nullable();
			$table->datetime('updated_at');
        });
		
		// Insert some Adjustment
		$data = array(
			'adjustment' => 'Damaged',
			'remarks' => 'Barang rosak',
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Expired';
		$data['remarks'] = 'Bad';
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Losing';
		$data['remarks'] = 'Losing - Courier Service';
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Charge Out - Demo';
		$data['remarks'] = 'Charge Out - Demo';
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Charge Out - Event';
		$data['remarks'] = 'Charge Out - Event';
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Charge Out - Sample';
		$data['remarks'] = 'Charge Out - Sample';
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Charge Out - Sponsor';
		$data['remarks'] = 'Charge Out - Sponsor';
		DB::table('config_stockadjustment')->insert($data);
		
		$data['adjustment'] = 'Charge Out - Testimony';
		$data['remarks'] = 'Charge Out - Testimony';
		DB::table('config_stockadjustment')->insert($data);
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_stockadjustment');
    }
}
