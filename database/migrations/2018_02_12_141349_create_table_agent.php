<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agentmaster', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('agent_username',50);
            $table->string('agent_type',50);
            $table->string('agent_name',50);
            $table->string('agent_date_of_birth',50);
            $table->string('agent_gender',50);
            $table->string('agrnt_marital_status',50);
            $table->string('agent_race',50);
            $table->string('agent_id_type',50);
            $table->string('agent_id',50);
            $table->string('agent_photo_id',300);
            $table->string('agent_profile_photo',300);
            $table->string('agent_mobile_no',50);
            $table->string('agent_email',50);
            $table->string('agent_street',100);
            $table->string('agent_postcode',50);
            $table->string('agent_city',50);
            $table->string('agent_country',50);
            $table->string('agent_bank_name',50);
            $table->string('agent_bank_acc_no',50);
            $table->string('agent_bank_acc_name',50);
            $table->string('agent_bank_acc_type',50);
            $table->string('agent_benefical_name',50);
            $table->string('agent_delivery_type',50);
            $table->string('agent_payment_type',50);
            $table->string('agent_secqurity_pass',50);
            $table->string('agent_payment_type1',50);
            $table->string('created_by',50);
            $table->string('updated_by',50);
            $table->timestamps();

            $table->primary(['agent_username','agent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agentmaster');
    }
}
