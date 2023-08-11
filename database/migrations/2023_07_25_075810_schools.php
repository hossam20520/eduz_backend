<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Schools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
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
            $table->text('logo')->nullable();
            $table->text('banner')->nullable();

            
            $table->text('activities_image')->nullable();
            $table->integer('institution_id')->nullable()->index('institution_id');
            $table->integer('area_id')->nullable()->index('area_id');

            $table->integer('gov_id')->nullable()->index('gov_id');


            $table->text('facebook_url')->nullable();
            $table->text('instgram_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('selected_ids')->nullable();

            
            $table->text('second_lang')->nullable();
            $table->text('first_lang')->nullable();
            $table->text('other_lang')->nullable();
            $table->text('years_accepted')->nullable();
            $table->text('weekend')->nullable();
            $table->text('children_numbers')->nullable();
            $table->text('is_accept')->nullable();
 
            // second_lang
            $table->float('expense_from', 10, 0)->nullable();
            $table->float('expense_to', 10, 0)->nullable();
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
        //
    }
}
