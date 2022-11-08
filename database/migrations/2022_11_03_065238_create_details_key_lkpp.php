<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsKeyLkpp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_key_lkpp', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('x-client-id')->nullable();
            $table->string('x-client-secret')->nullable();
            $table->string('x-vertical-type')->nullable();
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
        Schema::dropIfExists('details_key_lkpp');
    }
}
