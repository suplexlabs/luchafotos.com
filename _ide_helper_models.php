<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Bookmark
 *
 * @property int $id
 * @property int $user_id
 * @property int $link_id
 * @property \Illuminate\Support\Carbon $date_added
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Link $link
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereDateAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUserId($value)
 */
	class Bookmark extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Channel
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newQuery()
 * @method static \Illuminate\Database\Query\Builder|Channel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Channel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Channel withoutTrashed()
 */
	class Channel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $abbr
 * @property string $code
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $is_official
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company official()
 * @method static \Illuminate\Database\Query\Builder|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAbbr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIsOfficial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withoutTrashed()
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Device
 *
 * @property int $id
 * @property int $user_id
 * @property string $model
 * @property string $platform
 * @property string $vendor_id
 * @property string|null $push_token
 * @property \Illuminate\Support\Carbon $last_accessed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Query\Builder|Device onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLastAccessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePushToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereVendorId($value)
 * @method static \Illuminate\Database\Query\Builder|Device withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Device withoutTrashed()
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $type
 * @property string $unique_id
 * @property string $name
 * @property string $code
 * @property string|null $preview
 * @property int $company_id
 * @property int $day_of_week
 * @property \Illuminate\Support\Carbon|null $air_date
 * @property \Illuminate\Support\Carbon $date_of_event
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property string|null $timezone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventAddress|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \App\Models\Company $company
 * @property-read mixed $color
 * @property-read mixed $timezone_formatted
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAirDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDateOfEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDayOfWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventAddress
 *
 * @method static SpatialBuilder query()
 * @property int $id
 * @property int $event_id
 * @property string $name
 * @property string|null $address
 * @property string|null $address_2
 * @property string $city
 * @property string|null $state
 * @property string|null $state_name
 * @property string $postal_code
 * @property string $country
 * @property string|null $country_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \MatanYadaev\EloquentSpatial\Objects\Geometry|null|null $lat_long
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereLatLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAddress whereUpdatedAt($value)
 */
	class EventAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventChannel
 *
 * @property int $id
 * @property int $event_id
 * @property int $channel_id
 * @method static \Illuminate\Database\Eloquent\Builder|EventChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventChannel newQuery()
 * @method static \Illuminate\Database\Query\Builder|EventChannel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventChannel whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventChannel whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventChannel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|EventChannel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EventChannel withoutTrashed()
 */
	class EventChannel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Group
 *
 * @property int $id
 * @property string $name
 * @property int|null $sort_order
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupItem[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Source[] $sources
 * @property-read int|null $sources_count
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Query\Builder|Group onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Group withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Group withoutTrashed()
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupItem
 *
 * @property int $id
 * @property int $group_id
 * @property string $entity_type
 * @property int $entity_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Source|null $source
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupItem whereUpdatedAt($value)
 */
	class GroupItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Link
 *
 * @property int $id
 * @property string|null $unique_id
 * @property int $source_id
 * @property int $is_active
 * @property string $type
 * @property string $title
 * @property string $code
 * @property string $guid
 * @property string $url
 * @property string|null $content
 * @property \Illuminate\Support\Carbon $publish_date
 * @property \Illuminate\Support\Carbon $featured_until_date
 * @property string|null $wrestlability
 * @property int|null $num_page_views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\LinkAudio|null $audio
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @property-read array $company_names
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Source $source
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Topic[] $topics
 * @property-read int|null $topics_count
 * @method static \Plank\Mediable\MediableCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Link articles()
 * @method static \Illuminate\Database\Eloquent\Builder|Link byCompany(string $company)
 * @method static \Plank\Mediable\MediableCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link noSpoilers()
 * @method static \Illuminate\Database\Query\Builder|Link onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Link podcasts()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link videos()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereFeaturedUntilDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereNumPageViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereWrestlability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Link withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Link withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Link withMediaMatchAll(bool $tags = [], bool $withVariants = false)
 * @method static \Illuminate\Database\Query\Builder|Link withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Link withoutTrashed()
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LinkAudio
 *
 * @property int $id
 * @property int $link_id
 * @property string $url
 * @property int|null $duration
 * @property int|null $episode
 * @property int|null $season
 * @property int $is_explicit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio query()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereEpisode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereIsExplicit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereSeason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkAudio whereUrl($value)
 */
	class LinkAudio extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $disk
 * @property string $directory
 * @property string $filename
 * @property string $extension
 * @property string $mime_type
 * @property string $aggregate_type
 * @property int $size
 * @property string|null $variant_name
 * @property int|null $original_media_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $height
 * @property int|null $width
 * @property-read string $basename
 * @property-read Media|null $originalMedia
 * @property-read \Illuminate\Database\Eloquent\Collection|Media[] $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|Media forPathOnDisk(string $disk, string $path)
 * @method static \Illuminate\Database\Eloquent\Builder|Media inDirectory(string $disk, string $directory, bool $recursive = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Media inOrUnderDirectory(string $disk, string $directory)
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media unordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereAggregateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereBasename(string $basename)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDirectory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereIsOriginal()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereIsVariant(?string $variant_name = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereOriginalMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereVariantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereWidth($value)
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Query\Builder|Setting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Query\Builder|Setting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Setting withoutTrashed()
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Source
 *
 * @property int $id
 * @property string|null $unique_id
 * @property string $name
 * @property string|null $description
 * @property string $code
 * @property string|null $site
 * @property string|null $rss
 * @property string $type
 * @property string|null $wrestlability
 * @property int|null $sort_order
 * @property int $is_active
 * @property int $needs_to_be_imported
 * @property int $is_official
 * @property string|null $last_check_date
 * @property \Illuminate\Support\Carbon|null $next_check_date
 * @property int|null $minutes_to_check_for_updates
 * @property string|null $itunes_id
 * @property string|null $itunes_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Group|null $group
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\Link[] $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubscribedPodcast[] $subscribedPodcasts
 * @property-read int|null $subscribed_podcasts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Source blogs()
 * @method static \Illuminate\Database\Eloquent\Builder|Source newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Source newQuery()
 * @method static \Illuminate\Database\Query\Builder|Source onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Source podcasts()
 * @method static \Illuminate\Database\Eloquent\Builder|Source query()
 * @method static \Illuminate\Database\Eloquent\Builder|Source videos()
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereIsOfficial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereItunesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereItunesUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereLastCheckDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereMinutesToCheckForUpdates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereNeedsToBeImported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereNextCheckDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereRss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereWrestlability($value)
 * @method static \Illuminate\Database\Query\Builder|Source withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Source withoutTrashed()
 */
	class Source extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubscribedEpisode
 *
 * @property int $id
 * @property int $subscribed_podcast_id
 * @property int $link_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode whereSubscribedPodcastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedEpisode whereUpdatedAt($value)
 */
	class SubscribedEpisode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubscribedPodcast
 *
 * @property int $id
 * @property int $user_id
 * @property int $source_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $last_check_for_episodes_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\Link[] $episodes
 * @property-read int|null $episodes_count
 * @property-read \App\Models\Source $source
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubscribedEpisode[] $subscribedEpisodes
 * @property-read int|null $subscribed_episodes_count
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereLastCheckForEpisodesDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedPodcast whereUserId($value)
 */
	class SubscribedPodcast extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Topic
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property array|null $aliases
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\Link[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Topic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Topic newQuery()
 * @method static \Illuminate\Database\Query\Builder|Topic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Topic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereAliases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Topic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Topic withoutTrashed()
 */
	class Topic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $name
 * @property string $type
 * @property int $is_active
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $last_accessed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bookmark[] $bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read int|null $devices_count
 * @property-read mixed $app_darkmode
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read mixed $show_spoilers
 * @property-read mixed $system_dark_mode
 * @property-read mixed $use_reader_mode
 * @property-read int|null $notifications_count
 * @property-read \App\Models\UserSetting|null $settings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubscribedPodcast[] $subscribedPodcasts
 * @property-read int|null $subscribed_podcasts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastAccessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * App\Models\UserSetting
 *
 * @property int $id
 * @property int $user_id
 * @property int $app_dark_mode
 * @property int $system_dark_mode
 * @property int $show_spoilers
 * @property int $use_reader_mode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserSettingNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserSetting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereAppDarkMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereShowSpoilers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereSystemDarkMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUseReaderMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSetting whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserSetting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserSetting withoutTrashed()
 */
	class UserSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserSettingNotification
 *
 * @property int $id
 * @property int $user_setting_id
 * @property string $name
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserSettingNotification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereUserSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettingNotification whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|UserSettingNotification withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserSettingNotification withoutTrashed()
 */
	class UserSettingNotification extends \Eloquent {}
}

