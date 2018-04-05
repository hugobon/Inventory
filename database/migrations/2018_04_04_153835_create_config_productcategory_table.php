<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigProductcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_productcategory', function (Blueprint $table) {
            $table->increments('id');
			$table->string('category')->comment('Product Category');
			$table->longText('remarks');
			$table->integer('status')->comment('0: inactive, 1: active')->default('1');
			$table->integer('created_by')->comment('User ID')->nullable();
			$table->integer('updated_by')->comment('User ID')->nullable();
            $table->timestamps();
        });
		
		// Insert some Product Category
		$data = array(
			'category' => 'Health / Nutritious',
			'remarks' => 'Kesihatan / Berkhasiat',
			'status' => '1',
			'created_by' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_by' => 1,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		DB::table('config_productcategory')->insert($data);
		
		$data['category'] = 'Beauty';
		$data['remarks'] = 'Kecantikan';
		DB::table('config_productcategory')->insert($data);
		
		$data['category'] = 'Beauty & Health';
		$data['remarks'] = 'Kesihatan & Kecantikan';
		DB::table('config_productcategory')->insert($data);
		
		$data['category'] = 'Leaflet';
		$data['remarks'] = 'Risalah';
		DB::table('config_productcategory')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_productcategory');
    }
}
