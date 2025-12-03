<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('worker_schedules', function (Blueprint $table) {
            $table->date('booked_date')->nullable()->after('is_available');
            $table->boolean('is_booked')->default(false)->after('booked_date');
        });
    }

    public function down()
    {
        Schema::table('worker_schedules', function (Blueprint $table) {
            $table->dropColumn(['booked_date', 'is_booked']);
        });
    }
};