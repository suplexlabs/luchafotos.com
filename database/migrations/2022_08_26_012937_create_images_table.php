<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->cascadeOnDelete();
            $table->mediumText('url');
            $table->string('domain');
            $table->string('title')->nullable();
            $table->string('etag')->nullable();
            $table->integer('height')->index();
            $table->integer('width')->index();
            $table->date('published_at')->index();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('image_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_id')->constrained()->cascadeOnDelete();
            $table->foreignId('link_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('image_links');
    }
};
