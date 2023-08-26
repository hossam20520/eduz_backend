<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Deals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('ar_name', 192)->nullable();
            $table->string('en_name', 192)->nullable();
            $table->string('ar_desc', 200)->nullable();
            $table->string('en_desc', 200)->nullable();
            $table->string('type', 200)->nullable();
            $table->string('child_id', 200)->nullable();
            $table->text('image')->nullable();
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
