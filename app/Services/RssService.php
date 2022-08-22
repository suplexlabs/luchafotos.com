<?php

namespace App\Services;

use App\Datas\LinkInfo;
use App\Services\Interfaces\SourceServiceInterface;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use FeedIo\Factory;
use FeedIo\Feed\Item;
use App\Datas\RssIntervals;
use App\Models\Source;
use Http;
use shweshi\OpenGraph\Exceptions\FetchException;
use shweshi\OpenGraph\OpenGraph;

class RssService implements SourceServiceInterface
{
    public function load(string $url, array $params = []): mixed
    {
        $factory = Factory::create()->getFeedIo();
        return $factory->read($url)->getFeed();
    }

    public function getImages(Source $source, LinkInfo $info)
    {
        $images = [];

        if ($source->isPodcast() && $info->audio) {
            $images[] = $info->audio->image;
        }

        if ($source->isBlog() || $source->isTwitter() || $source->isCrawler()) {
            try {
                $og = new OpenGraph();
                $metas = $og->fetch($info->url, true);

                $images[] = data_get(
                    $metas,
                    'og:image'
                ) ?:
                    data_get(
                        $metas,
                        'twitter:image'
                    ) ?: data_get(
                        $metas,
                        'image'
                    );
            } catch (FetchException $e) {
                // skip for now
                Bugsnag::notifyException($e);
            }
        }

        $images = collect($images)->filter(function ($path) {
            if (empty($path)) {
                return false;
            }

            try {
                $response = Http::get($path);
                return $response->successful();
            } catch (\Exception $e) {
                return false;
            }
        })->toArray();

        return $images;
    }

    public function intervals(?Item $item): RssIntervals
    {
        $data = [
            'lastCheckDate' => Carbon::now(),
        ];

        $diffDays = $item ? Carbon::parse($item->getLastModified())->diffInDays() : 1;
        $weekInMinutes = 10080;

        // if it's been too long since the last update check the sooner
        if ($diffDays >= 42) {
            // check in two weeks
            $minutesToCheckForUpdates = $weekInMinutes * 2;
        } else if ($diffDays >= 28) {
            // check in one week
            $minutesToCheckForUpdates = $weekInMinutes;
        } else if ($diffDays > 7) {
            // check every 6 hours
            $minutesToCheckForUpdates = 60 * 6;
        } else {
            // check every 30 minutes
            $minutesToCheckForUpdates = 30;
        }

        $data['minutesToCheckForUpates'] = $minutesToCheckForUpdates;
        $data['nextCheckDate'] = Carbon::now()->addMinutes($minutesToCheckForUpdates);

        return RssIntervals::from($data);
    }

    public function timeToSeconds(string $time): int
    {
        $arr = explode(':', $time);
        if (count($arr) == 3) {
            return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
        } else {
            return $arr[0] * 60 + $arr[1];
        }
    }

    public function getFinalUrl(string $url): string
    {
        $ch = curl_init();
        if (!$ch) {
            return $url;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        return $url;
    }
}
