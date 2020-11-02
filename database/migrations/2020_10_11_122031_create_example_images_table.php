<?php

use App\ExampleImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExampleImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('example_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('status')->default(ExampleImage::STATUS_ACTIVE);

            $table->unsignedBigInteger('example_id');
            $table->foreign('example_id')->references('id')->on('examples')->cascadeOnDelete();

            $table->string('filename', 255);

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
        Schema::dropIfExists('example_images');
    }
}
