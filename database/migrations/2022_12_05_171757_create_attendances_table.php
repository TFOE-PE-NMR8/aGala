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

        Schema::table('guests', function (Blueprint $table) {
            $table->string('is_attend')->nullable();
        });
        Schema::table('registrants', function (Blueprint $table) {
            $table->string('is_attend')->nullable();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->dateTime('date_time')->nullable()->default(Carbon::now());
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->unsignedBigInteger('registrant_id')->nullable();
            $table->dateTime('paid_updated')->nullable();
            $table->timestamps();

            $table->foreign('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');

            $table->foreign('registrant_id')
                ->references('id')
                ->on('registrants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }


};
