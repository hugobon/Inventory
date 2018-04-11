<?php

use Illuminate\Database\Seeder;

class StockadjustmentConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert some Adjustment
		$data = array(
			'adjustment' => 'Damaged',
			'remarks' => 'Barang rosak',
			'operation' => "-",
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
}
