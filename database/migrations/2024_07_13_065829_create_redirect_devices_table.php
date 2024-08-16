<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirect_devices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('redirect_note_slug')->unique();
            $table->string('redirect_note_number');
            $table->string('redirect_note_image')->nullable();
            $table->string('redirect_note_status');

            $table->string('device_from_side_institution')->nullable();
            $table->string('device_from_side_by_employee');
            $table->bigInteger('from_employee_id')->unsigned()->nullable();
            $table->bigInteger('from_institution_id')->unsigned()->nullable();
            
            $table->string('device_to_side_institution')->nullable();
            $table->string('device_to_side_by_employee');
            $table->bigInteger('to_employee_id')->unsigned()->nullable();
            $table->bigInteger('to_institution_id')->unsigned()->nullable();

            $table->string('redirect_status');
            $table->integer('redirect_update_by_employee')->unsigned()->nullable();

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
        Schema::dropIfExists('redirect_devices');
    }
}
