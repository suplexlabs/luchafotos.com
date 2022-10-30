<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Image;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Image::whereNull('md5')->chunkById(500, function ($images) {
            foreach ($images as $image) {
                try {
                    $image->md5 = md5_file($image->url);
                    $image->save();
                } catch (Exception $e) {
                    continue;
                }
            }
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
};
