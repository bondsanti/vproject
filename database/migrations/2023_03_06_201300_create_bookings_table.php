<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_title');
            $table->string('booking_start');
            $table->string('booking_end');
            $table->string('booking_customer');
            $table->string('booking_customer_tel');
            $table->string('booking_doc_bank');
            $table->string('booking_customer_req');
            $table->string('booking_doc_personal');
            $table->string('booking_status');//สถานะการจองเยี่มโครงการ
            $table->string('booking_status_df');//สถานะการ DF
            $table->string('booking_confirm');//สถานะการจอง
            $table->string('teampro_id');//เจ้าหน้าที่รับผิดชอบ
            $table->string('team_id');
            $table->string('subteam_id');
            $table->string('sale_name');
            $table->string('sale_tel');
            $table->string('remark');
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
        Schema::dropIfExists('bookings');
    }
}
