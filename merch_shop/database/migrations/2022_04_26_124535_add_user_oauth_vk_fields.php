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
        Schema::table('users', function (Blueprint $table) {
           $table->string('email')->nullable()->change();
           $table->string('password')->nullable()->change();
           $table->string('vkontakte_id')->nullable()->unique();
           $table->dateTime('vkontakte_logged_in_at')->nullable();
            $table->dateTime('vkontakte_registered_at')->nullable();
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
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['vkontakte_id', 'vkontakte_logged_in_at', 'vkontakte_registered_at']);
        });
    }
};
