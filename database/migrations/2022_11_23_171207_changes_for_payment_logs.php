<?php

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
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('is_paid');
            $table->dropColumn('paid_user_id');
            $table->dropColumn('date_paid');
            $table->dropColumn('payment_method');
            $table->dropColumn('sms_registration_sent');
            $table->dropColumn('email_registration_sent');
            $table->dropColumn('sms_paid_sent');
            $table->dropColumn('email_paid_sent');
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
