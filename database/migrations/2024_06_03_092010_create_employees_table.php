<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('employee_slug')->unique();
            $table->string('employee_image')->nullable();
            $table->string('employee_full_name')->nullable()->index();
            $table->string('employee_father_name')->nullable();
            $table->string('employee_mother_name')->nullable();

            $table->timestamp('employee_birth_day')->nullable();
            $table->string('employee_birth_place')->nullable();
            
            $table->string('employee_national_number')->nullable(); // رقم وطني ---- 
            $table->string('employee_kid')->nullable();
            $table->string('employee_address')->nullable();
            $table->string('employee_marital_status')->nullable(); // الحالة الاجتماعية  ----
            $table->string('employee_speciality_certificate')->nullable(); // المؤهل العلمي ---- 
            $table->string('employee_phone_number')->nullable(); // رقم هاتف ---- 

            $table->string('employee_self_number')->nullable(); // رقم ذاتي ----
            $table->string('employee_job_naming')->nullable(); // التسمية الوظيفية ----
            $table->string('employee_speciality')->nullable(); // الاختصاص ---- 
            $table->string('employee_categortion')->nullable(); // الفئة ---- 
            $table->string('employee_department')->nullable(); // القسم ----
            $table->string('employee_job')->nullable(); // العمل المكلف به ----
            $table->string('employee_job_status')->nullable(); // وضعه في الملاك ----

            $table->string('employee_recruitmant_name')->nullable(); // شعبة التجنيد ----
            $table->string('employee_recruitmant_number')->nullable(); // رقم التجنيد ----
            $table->string('employee_recruitmant_backup_number')->nullable(); // رقم التجنيد ----


            $table->string('employee_shateb_number')->nullable(); // رقم الشطب ----
            $table->string('employee_financial_number')->nullable(); // رقم مالي ----

            
            $table->timestamp('employee_join_date')->nullable(); // تاريخ الإنضمام ----
            $table->timestamp('employee_leave_date')->nullable(); // تاريخ المغادرة ----

            $table->timestamp('employee_job_older')->nullable(); // القدم الوظيفي ---- 

            $table->bigInteger('institution_id')->unsigned()->nullable(); // رقم المنشأة التابع لها ---- 
            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('employees');
    }
}
