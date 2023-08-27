<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_m_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('division_id')->index()->nullable();
            $table->unsignedBigInteger('district_id')->index()->nullable();
            $table->unsignedBigInteger('thana_id')->index()->nullable();
            $table->unsignedBigInteger('customer_source_id')->index()->nullable();
            $table->unsignedBigInteger('customer_category_id')->index()->nullable();
            $table->unsignedBigInteger('customer_type_id')->index()->nullable();
            $table->unsignedBigInteger('customer_subcategory_id')->nullable();
            $table->unsignedBigInteger('outlet_id')->index()->nullable();
            $table->string('batch_id');
            $table->longText('text')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = Active | 0 = Inactive');
            $table->tinyInteger('type')->default(0)->comment('1 = Individual | 2 = Group');
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
        Schema::dropIfExists('s_m_s');
    }
}