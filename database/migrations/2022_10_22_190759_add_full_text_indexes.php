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
        Schema::table('images', function (Blueprint $table) {
            $table->fullText('title');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->fullText('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropFullText('images_title_fulltext');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropFullText('tags_name_fulltext');
        });
    }
};
