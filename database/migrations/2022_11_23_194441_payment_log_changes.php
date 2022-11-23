<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->decimal('total_amount')->nullable()->default(0)->change();
        });

        Schema::table('payment_logs', function (Blueprint $table) {
            $table->boolean('is_sms_sent')->default(false);
            $table->boolean('is_email_sent')->default(false);
            $table->dateTime('date')->nullable()->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
