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
            $table->boolean('is_active')->index()->default(false);
            $table->dateTime('last_check_at')->index()->nullable();
            $table->dateTime('next_check_at')->index()->nullable();
            $table->integer('minutes_to_check_for_updates')->unsigned()->index()->nullable();
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
