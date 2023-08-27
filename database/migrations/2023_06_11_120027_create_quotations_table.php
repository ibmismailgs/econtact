<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('quotation_type_id')->index();
            $table->unsignedBigInteger('meeting_id')->index()->nullable();
            $table->string('quotation_no');
            $table->double('amount');
            $table->date('date');
            $table->tinyInteger('status')->default(1)->comment('1 = Success | 2 = Pending | 3 =  Failled');
            $table->tinyInteger('is_requotation')->default(0)->nullable()->comment('1 = Yes | 0 = No');
            $table->date('requotation_date')->nullable();
            $table->longText('note')->nullable();
            $table->longText('status_note')->nullable();
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
        Schema::dropIfExists('quotations');
    }
}
