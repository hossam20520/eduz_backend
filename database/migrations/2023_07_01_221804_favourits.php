<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Favourits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

 
        Schema::create('favourits', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
            $table->integer('user_id')->nullable()->index('user_id');
            $table->string('title', 192)->nullable();
            $table->string('teacher_id', 192)->nullable();
            $table->string('product_id', 192)->nullable();
            $table->string('inst_id', 192)->nullable();
            $table->string('type', 192)->nullable();
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
