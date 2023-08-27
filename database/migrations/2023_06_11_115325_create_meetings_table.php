<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('meeting_type_id')->index();
            $table->string('title')->nullable();
            $table->date('date');
            $table->date('reschedule_date')->nullable();
            $table->time('time');
            $table->string('meeting_status')->default(1)->comment('1 = Success | 2 = Pending | 3 = Failled');
            $table->tinyInteger('is_reschedule')->default(0)->nullable()->comment('1 = Yes | 0 = No');
            $table->longText('note')->nullable();
            $table->longText('status_note')->nullable();
            $table->tinyInteger('addquotation')->default(0)->nullable()->comment('1 = Yes | 0 = No');
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
        Schema::dropIfExists('meetings');
    }
}
