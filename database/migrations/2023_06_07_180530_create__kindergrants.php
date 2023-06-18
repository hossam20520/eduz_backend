<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKindergrants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Kindergrants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('ar_name', 192)->nullable();
            $table->string('en_name', 192)->nullable();
            $table->text('en_info')->nullable();
            $table->text('ar_info')->nullable();
            $table->text('area_ar_1')->nullable();
            $table->text('area_en_1')->nullable();
            $table->text('area_ar_2')->nullable();
            $table->text('area_en_2')->nullable();
            $table->text('area_ar_3')->nullable();
            $table->text('area_en_3')->nullable();
            $table->text('area_ar_4')->nullable();
            $table->text('area_en_4')->nullable();
            $table->text('url')->nullable();
            $table->text('phone')->nullable();
            $table->text('share')->nullable();
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
        Schema::dropIfExists('kindergrants');
    }
}
