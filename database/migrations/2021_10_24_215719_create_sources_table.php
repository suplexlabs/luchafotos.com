<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->index()->nullable();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('code')->index();
            $table->string('site')->nullable();
            $table->string('rss')->nullable();
            $table->string('type')->index();
            $table->decimal('wrestlability')->index()->nullable();
            $table->integer('sort_order')->unsigned()->index()->nullable();
            $table->boolean('is_active')->index()->default(false);
            $table->boolean('use_readability')->index()->default(false);
            $table->boolean('needs_to_be_imported')->index()->default(false);
            $table->boolean('is_official')->index()->default(false);
            $table->dateTime('last_check_date')->index()->nullable();
            $table->dateTime('next_check_date')->index()->nullable();
            $table->integer('minutes_to_check_for_updates')->unsigned()->index()->nullable();
            $table->string('itunes_id')->nullable()->index();
            $table->string('itunes_url')->nullable()->index();
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
        Schema::dropIfExists('sources');
    }
}
