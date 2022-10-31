<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveImageDuplicates extends Command
{
    protected $signature = 'remove:image-duplicates';
    protected $description = 'Remove any duplicate images.';

    public function handle()
    {
        DB::table('images')
            ->select([DB::raw('MIN(id) AS id'), 'md5'])
            ->whereNotNull('md5')
            ->groupBy('md5')
            ->having(DB::raw('COUNT(id)'), '>', 1)
            ->orderBy('id')
            ->chunk(500, function ($records) {
                foreach ($records as $record) {
                    Image::where('md5', $record->md5)
                        ->where('id', '!=', $record->id)
                        ->forceDelete();
                }
            });

        $wweVideosPageId = 1;
        DB::table('images')
            ->select([DB::raw('MIN(id) AS id'), 'page_id'])
            ->where('source_id', $wweVideosPageId)
            ->groupBy('page_id')
            ->having(DB::raw('COUNT(id)'), '>', 1)
            ->orderBy('id')
            ->chunk(500, function ($records) {
                foreach ($records as $record) {
                    Image::where('id', $record->id)->forceDelete();
                }
            });
    }
}
