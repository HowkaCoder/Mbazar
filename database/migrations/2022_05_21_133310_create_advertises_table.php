<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertises', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('describtion');
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->string('price');
            $table->integer('view');
            $table->string('phone');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Category::class);
            $table->foreignIdFor(\App\Models\City::class);
            $table->boolean('top');
            $table->enum('status' , ['sell' , 'sold' , 'deleted']);
            $table->softDeletes();
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
        Schema::dropIfExists('advertises');
    }
}
