<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostIdColumnToSocialsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socials_posts', function (Blueprint $table) {
            $table->renameColumn('post_provider_id', 'provider_id');
            $table->string('social_post_id', 80)->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('socials_posts', function (Blueprint $table) {
            $table->renameColumn('provider_id', 'post_provider_id');
            $table->dropColumn('social_post_id');
        });
    }
}
