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
            $table->string('booking_status');//สถานะการจองเยี่มโครงการ  0 รอรับงาน, 1 รับงานแล้ว, 2 จองสำเร็จ/รอเข้าเยี่ม, 3 เยี่ยมชมเรียบร้อย, 4 ยกเลิกเลิกนัด, 5 ยกเลิกการจองโดยระบบ
            $table->string('project_id');
            $table->string('booking_status_df');//สถานะการ DF
            $table->string('teampro_id');//เจ้าหน้าที่รับผิดชอบ
            $table->string('team_id');
            $table->string('subteam_id');
            $table->string('user_id');
            $table->string('user_tel');
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
