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
        Schema::table('guests', function($table) {
            $table->boolean('is_paid')->default(false);
        });
        Schema::table('registrants', function($table) {
            $table->boolean('is_paid')->default(false);
        });
        Schema::table('registrations', function($table) {
            $table->decimal('paid_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn('is_paid');
        });
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
        });
    }
};
