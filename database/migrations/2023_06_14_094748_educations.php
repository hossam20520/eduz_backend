<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Educations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
            $table->text('en_name')->nullable();
            $table->text('ar_name')->nullable();
            $table->text('en_info')->nullable();
            $table->text('ar_info')->nullable();
            $table->text('facilities_ar')->nullable();
            $table->text('facilities_en')->nullable();
            $table->text('activities_ar')->nullable();
            $table->text('activities_en')->nullable();
            $table->text('url')->nullable();
            $table->text('phone')->nullable();
            $table->text('share')->nullable();
            $table->text('image')->nullable();
            $table->text('activities_image')->nullable();
            $table->integer('institution_id')->nullable()->index('institution_id');
            $table->integer('review_id')->nullable()->index('review_id');
            $table->text('lat')->nullable();
            $table->text('long_a')->nullable();
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
        Schema::dropIfExists('educations');
    }
}
