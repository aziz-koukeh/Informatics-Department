<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportRequestNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_request_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('export_request_note_slug')->unique();
            $table->integer('export_request_note_SN')->unique();
            $table->integer('export_request_note_folder');
            $table->string('export_request_image')->nullable();

            $table->string('export_request_note_status');
            
            $table->string('export_request_note_by_person');

            // $table->unsignedTinyInteger('export_status')->default(1);
            $table->string('export_status');
            $table->integer('export_update_by_employee')->unsigned()->nullable();
            
            $table->bigInteger('institution_id')->unsigned();
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
        Schema::dropIfExists('export_request_notes');
    }
}
