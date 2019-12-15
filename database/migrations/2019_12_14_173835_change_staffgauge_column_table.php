<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStaffgaugeColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staffgauge', function (Blueprint $table) {
            $table->renameColumn('latitude', 'latitudegauge');
            $table->renameColumn('longitude', 'longitudegauge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staffgauge', function (Blueprint $table) {
            //
        });
    }
}
