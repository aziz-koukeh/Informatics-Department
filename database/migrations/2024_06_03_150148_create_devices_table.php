<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_name')->index();
            $table->string('device_slug')->unique();
            $table->string('device_number')->index();
            $table->longText('device_details')->nullable();
            $table->string('device_model')->nullable();

            $table->string('device_weight')->nullable();
            $table->string('device_image')->nullable();

            $table->longText('device_belongings')->nullable();
            $table->integer('device_belongings_count')->nullable();

            $table->string('device_file_card')->index();
            $table->longText('device_notes')->nullable();

            $table->string('device_infos')->nullable();
            $table->longText('device_report')->nullable();


            $table->unsignedTinyInteger('device_status')->default(1);

            $table->bigInteger('institution_id')->unsigned()->nullable();
            $table->bigInteger('sub_institution_id')->unsigned()->nullable();
            $table->bigInteger('employee_id')->unsigned()->nullable();
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
        Schema::dropIfExists('devices');
    }
}
