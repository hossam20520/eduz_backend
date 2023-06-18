<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Teachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('ar_name', 192)->nullable();
            $table->string('en_name', 192)->nullable();
            $table->string('ar_country', 192)->nullable();
            $table->string('en_country', 192)->nullable();
            $table->string('en_subject', 192)->nullable();
            $table->string('ar_subject', 192)->nullable();
            $table->string('age_from', 192)->nullable();
            $table->string('age_to', 192)->nullable();
            $table->text('ar_about')->nullable();
            $table->text('en_about')->nullable();
            $table->string('share', 192)->nullable();
            $table->text('image')->nullable();
            $table->integer('user_id')->nullable()->index('user_id');
            $table->integer('institution_id')->nullable()->index('institution_id');
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
        Schema::dropIfExists('teachers');
    }
}
