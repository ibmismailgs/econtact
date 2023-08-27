<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('call_type_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->longText('note')->nullable();
            $table->tinyInteger('re_call')->nullable();
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
        Schema::dropIfExists('call_management');
    }
}
