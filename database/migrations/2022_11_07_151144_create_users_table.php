<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('vertical_type')->nullable();
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->string('role')->nullable();
            $table->string('lpseId')->nullable();
            $table->string('isLatihan')->default('0');
            $table->string('time')->nullable();
            $table->string('idInstansi')->nullable();
            $table->string('namaInstansi')->nullable();
            $table->string('idSatker')->nullable();
            $table->string('namaSatker')->nullable();
            $table->string('token_lkpp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn(['client_id', 'client_secret','vertical_type','username','phone','lpseId','isLatihan','time','idInstansi','namaInstansi','idSatker','namaSatker','token_lkpp']);
        });
    }
}
