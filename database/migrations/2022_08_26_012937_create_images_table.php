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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('domain');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->mediumText('url');
            $table->string('title')->nullable();
            $table->string('etag')->nullable();
            $table->integer('height')->index();
            $table->integer('width')->index();
            $table->date('published_at')->index();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('image_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_tags');
        Schema::dropIfExists('images');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('sites');
    }
};
