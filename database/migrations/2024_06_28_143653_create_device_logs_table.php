<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_log_status');
            $table->string('device_by_person');

            $table->bigInteger('export_request_note_id')->unsigned()->nullable();

            $table->bigInteger('import_request_note_id')->unsigned()->nullable();

            $table->bigInteger('redirect_devices_note_id')->unsigned()->nullable();

            $table->bigInteger('device_id')->unsigned();

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
        Schema::dropIfExists('device_logs');
    }
}
