<?php

namespace App\Enums;

enum Sources: string
{
    case PODCAST = 'podcast';
    case YOUTUBE = 'youtube';
    case BLOG = 'blog';
    case TWITTER = 'twitter';
    case CRAWLER = 'crawler';
}
