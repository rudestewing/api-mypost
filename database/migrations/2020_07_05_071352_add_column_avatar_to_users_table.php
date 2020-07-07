<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_file_id')->nullable();
            $table->string('id_card_file_id')->nullable();

            $table->foreign('avatar_file_id')->references('id')->on('files');
            $table->foreign('id_card_file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign([
                'avatar_file_id'
            ]);
            $table->dropForeign([
                'id_card_file_id'
            ]);

            $table->dropColumn('avatar_file_id');
            $table->dropColumn('id_card_file_id');

        });
    }
}
