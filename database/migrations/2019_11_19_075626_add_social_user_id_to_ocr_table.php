<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialUserIdToOcrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ocrs', function (Blueprint $table) {
            $table->text("json_line")->nullable();        //foreign key
            $table->string("social_user_id")->nullable();
            $table->text("numbers")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ocrs', function (Blueprint $table) {
            //
        });
    }
}
