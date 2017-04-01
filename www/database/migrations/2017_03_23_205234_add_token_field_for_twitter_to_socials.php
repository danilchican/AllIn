<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenFieldForTwitterToSocials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_social_account', function (Blueprint $table) {
            $table->string('access_token_secret')->after('access_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_social_account', function (Blueprint $table) {
            $table->removeColumn('access_token_secret');
        });
    }
}
