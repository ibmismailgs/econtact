<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id')->index();
            $table->unsignedBigInteger('district_id')->index();
            $table->unsignedBigInteger('thana_id')->index();
            $table->unsignedBigInteger('client_source_id')->index();
            $table->unsignedBigInteger('customer_category_id')->index();
            $table->unsignedBigInteger('customer_subcategory_id')->nullable();
            $table->unsignedBigInteger('customer_type_id')->index();
            $table->unsignedBigInteger('outlet_id')->index();
            $table->unsignedBigInteger('assign_to')->index()->nullable();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('designation')->nullable();
            $table->string('primary_phone');
            $table->string('secondary_phone')->nullable();
            $table->string('email')->nullable();
            $table->text('attachment')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = Active | 0 = Inactive');
            $table->tinyInteger('is_meeting')->default(0)->comment('1 = Meeting | 0 = No ');
            $table->tinyInteger('is_call')->default(0)->comment('1 = Yes | 0 = No ');
            $table->longText('note')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->tinyInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
