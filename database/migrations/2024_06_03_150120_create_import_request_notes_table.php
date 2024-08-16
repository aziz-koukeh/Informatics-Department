<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportRequestNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_request_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('import_request_note_slug')->unique();
            $table->integer('import_request_note_SN')->unique();
            $table->integer('import_request_note_folder');
            $table->string('import_request_image')->nullable();

            $table->string('import_request_note_status');
            $table->string('import_device_source');
            $table->string('import_device_source_from_employee');

            $table->string('import_type');
            $table->bigInteger('institution_id')->unsigned()->nullable();
            $table->bigInteger('employee_id')->unsigned()->nullable();

            // $table->unsignedTinyInteger('import_status')->default(1);
            $table->string('import_status');
            $table->integer('import_update_by_employee')->unsigned()->nullable();

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
        Schema::dropIfExists('import_request_notes');
    }
}
