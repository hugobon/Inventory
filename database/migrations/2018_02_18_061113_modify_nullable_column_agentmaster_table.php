<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyNullableColumnAgentmasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agentmaster', function (Blueprint $table) {
            //
            $table->string('agent_type',50)->nullable()->change();
            $table->string('agent_name',50)->nullable()->change();
            $table->string('agent_date_of_birth',50)->nullable()->change();
            $table->string('agent_gender',50)->nullable()->change();
            $table->string('agrnt_marital_status',50)->nullable()->change();
            $table->string('agent_race',50)->nullable()->change();
            $table->string('agent_id_type',50)->nullable()->change();
            $table->string('agent_photo_id',300)->nullable()->change();
            $table->string('agent_profile_photo',300)->nullable()->change();
            $table->string('agent_mobile_no',50)->nullable()->change();
            $table->string('agent_email',50)->nullable()->change();
            $table->string('agent_street',100)->nullable()->change();
            $table->string('agent_postcode',50)->nullable()->change();
            $table->string('agent_city',50)->nullable()->change();
            $table->string('agent_country',50)->nullable()->change();
            $table->string('agent_bank_name',50)->nullable()->change();
            $table->string('agent_bank_acc_no',50)->nullable()->change();
            $table->string('agent_bank_acc_name',50)->nullable()->change();
            $table->string('agent_bank_acc_type',50)->nullable()->change();
            $table->string('agent_benefical_name',50)->nullable()->change();
            $table->string('agent_delivery_type',50)->nullable()->change();
            $table->string('agent_payment_type',50)->nullable()->change();
            $table->string('agent_secqurity_pass',50)->nullable()->change();
            $table->string('agent_payment_type1',50)->nullable()->change();
            $table->string('created_by',50)->nullable()->change();
            $table->string('updated_by',50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agentmaster', function (Blueprint $table) {
            //
        });
    }
}
