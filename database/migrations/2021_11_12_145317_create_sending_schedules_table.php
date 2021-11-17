<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SendingSchedule;

class CreateSendingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_group_id')->references('id')->on('customer_groups');
            $table->foreignId('email_template_id')->references('id')->on('email_templates');
            $table->timestamp('time')->useCurrent();
            $table->unsignedTinyInteger('status')->default(SendingSchedule::STATUS_NOT_SENT);
            $table->foreignId('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sending_schedules');
    }
}
