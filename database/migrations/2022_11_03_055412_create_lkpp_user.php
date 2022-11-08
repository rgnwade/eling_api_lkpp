<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkppUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lkpp_user', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('password')->nullable();
            $table->string('vertical_type')->nullable();
            $table->string('userName')->nullable();
            $table->string('realName')->nullable();
            $table->string('phone')->nullable();
            $table->string('role')->nullable();
            $table->string('lpseId')->nullable();
            $table->string('isLatihan')->nullable();
            $table->string('email')->nullable();
            $table->string('time')->nullable();
            $table->string('idInstansi')->nullable();
            $table->string('namaInstansi')->nullable();
            $table->string('idSatker')->nullable();
            $table->string('namaSatker')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lkpp_user');
    }
}
