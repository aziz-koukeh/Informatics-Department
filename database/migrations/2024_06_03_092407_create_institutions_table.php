<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('institution_name')->index();
            $table->string('institution_slug')->unique();
            $table->string('institution_kind')->index(); // مدارس حلقة  1 -- مدارس حلقة 2 -- ثانويات عامة -- مجمعات -- ثانوي مهني -- معاهد مهني -- دوائر فرعية -- دوائر عامة 
            $table->string('institution_phone')->index();
            $table->string('institution_manager')->index(); // المدير ----
            $table->string('institution_storekeeper')->index()->nullable(); //  أمين المستودع ---
            $table->string('institution_amanuensis')->index()->nullable(); // أمين السر ----

            $table->string('institution_address')->nullable();
            $table->string('institution_image')->nullable();
            $table->longText('institution_bio')->nullable();
            
            $table->longText('institution_map')->nullable();
            
            $table->bigInteger('parent_institution_id')->unsigned()->nullable();

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
        Schema::dropIfExists('institutions');
    }
}
