<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->index()->nullable();
            $table->foreignId('source_id')->constrained();
            $table->boolean('is_active')->default(false);
            $table->string('type')->index();
            $table->string('title', 700);
            $table->string('code', 700)->index();
            $table->string('guid', 700)->index();
            $table->mediumText('url');
            $table->longText('content')->nullable();
            $table->dateTime('publish_date')->index();
            $table->dateTime('featured_until_date')->index();
            $table->decimal('wrestlability')->nullable()->index();
            $table->integer('num_page_views')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('link_audio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->cascadeOnDelete();
            $table->mediumText('url', 500);
            $table->integer('duration')->unsigned()->index()->nullable();
            $table->integer('episode')->unsigned()->index()->nullable();
            $table->integer('season')->unsigned()->index()->nullable();
            $table->boolean('is_explicit')->default(false)->index();
            $table->timestamps();
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
        Schema::dropIfExists('links');
        Schema::dropIfExists('link_audio');
    }
}
