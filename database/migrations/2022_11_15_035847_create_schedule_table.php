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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('dentist_id');
            $table->date('date');
            $table->integer('hour');
            $table->unsignedInteger('service_id');
            $table->smallInteger('status_id');
            $table->timestamps();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dentist_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
