<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SendingsCustomer;

class CreateSendingsCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendings_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sending_schedule_id')->references('id')->on('sending_schedules');
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->unsignedTinyInteger('status')->default(SendingsCustomer::STATUS_NOT_SENT);
            $table->timestamp('sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sendings_customers');
    }
}
