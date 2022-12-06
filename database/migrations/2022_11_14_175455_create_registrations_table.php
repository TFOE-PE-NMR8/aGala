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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('registrant_id')->unsigned()->index()->nullable();
            $table->string('reference_number')->unique();
            $table->decimal('total_amount')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->bigInteger('paid_user_id')->unsigned()->index()->nullable();
            $table->dateTime('date_paid')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('sms_registration_sent')->default(false);
            $table->boolean('email_registration_sent')->default(false);
            $table->boolean('sms_paid_sent')->default(false);
            $table->boolean('email_paid_sent')->default(false);
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
        Schema::dropIfExists('registrations');
    }
};
