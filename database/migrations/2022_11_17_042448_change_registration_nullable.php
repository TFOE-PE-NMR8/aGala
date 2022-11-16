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
        Schema::table('registrations', function (Blueprint $table) {
            $table->bigInteger('registrant_id')->unsigned()->change();
            $table->decimal('total_amount')->nullable()->change();
            $table->bigInteger('paid_user_id')->unsigned()->nullable()->change();
            $table->dateTime('date_paid')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->bigInteger('registrant_id')->unsigned()->nullable()->change();
            $table->decimal('total_amount')->nullable()->change();
            $table->bigInteger('paid_user_id')->unsigned()->nullable()->change();;
            $table->dateTime('date_paid')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
        });
    }
};
