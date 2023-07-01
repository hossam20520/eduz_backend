<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Clanaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calanders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
            $table->integer('user_id')->nullable()->index('user_id');
            $table->string('place', 192)->nullable();
            $table->string('time', 192)->nullable();
            $table->string('date', 192)->nullable();
            $table->string('with_one', 192)->nullable();
            $table->string('with_tow', 192)->nullable();
			$table->timestamps(6);
			$table->softDeletes();
        });


 
  
     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
