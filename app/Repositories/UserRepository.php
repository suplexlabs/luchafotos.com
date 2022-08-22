<?php

namespace App\Repositories;

use App\Enums\SubscribedPodcasts;
use App\Enums\Users;
use App\Models\User;
use Carbon\Carbon;
use App\Repositories\BaseRepository;
use Str;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    /**
     * @param int $userId
     * @param string $deviceId
     *
     * @return \App\Models\User
     */
    public function getUserByDevice(int $userId = null, string $deviceId = null): User
    {
        $user = $this->model
            ->where(function ($query) use ($userId, $deviceId) {
                if ($userId) {
                    $query->where('users.id', $userId);
                } else if ($deviceId) {
                    $query->whereHas('devices', function ($query) use ($deviceId) {
                        $query->where('vendor_id', $deviceId);
                    });
                }
            })
            ->first();

        if ($user) {
            $user->last_accessed_at = Carbon::now();
            $user->save();
        } else {
            $user = $this->model->create([
                'type'             => Users::ANON,
                'is_active'        => true,
                'last_accessed_at' => Carbon::now()
            ]);
            $user->createDefaultNotifications();
        }

        $user->refresh();

        return $user;
    }

    /**
     * @param \Carbon\Carbon $lastAccessedAt
     *
     * @return \Illuminate\Support\Collection|\App\Models\User[]
     */
    public function getUsersToNotify(Carbon $lastAccessedAt)
    {
        return $this->model
            ->where('last_accessed_at', '>=', $lastAccessedAt)
            ->get();
    }

    /**
     * @return \App\Models\User[]|\Illuminate\Support\Collection
     */
    public function getUsersSubscribedToPodcasts(Carbon $lastAccessedAt)
    {
        return $this->model
            ->whereHas('subscribedPodcasts', function ($query) {
                $query->where('type', SubscribedPodcasts::SUBSCRIBED);
            })
            ->where(function ($query) {
                $query
                    ->whereDoesntHave('settings.notifications')
                    ->orWhereHas('settings.notifications', function ($query) {
                        $query->where('name', 'new_podcast_episodes')
                            ->where('value', true);
                    });
            })
            ->where('last_accessed_at', '>=', $lastAccessedAt)
            ->get();
    }

    /**
     * @param \App\Models\User $user
     * @param bool $appDarkMode
     * @param bool $systemDarkMode
     * @param bool $showSpoilers
     * @param bool $useReaderMode
     *
     * @return \App\Models\UserSetting
     */
    public function saveSettings(User $user, bool $appDarkMode, bool $systemDarkMode, bool $showSpoilers, bool $useReaderMode)
    {
        return $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'app_dark_mode' => $appDarkMode,
                'system_dark_mode' => $systemDarkMode,
                'show_spoilers' => $showSpoilers,
                'use_reader_mode' => $useReaderMode,
            ]
        );
    }

    public function saveNotifications(User $user, $values)
    {
        foreach ($values as $name => $value) {
            $name = str_replace('p_', 'p', Str::snake($name));

            $user->settings->notifications()->updateOrCreate(
                [
                    'user_setting_id' => $user->settings->id,
                    'name'            => $name,
                ],
                [
                    'user_setting_id' => $user->settings->id,
                    'name'            => $name,
                    'value'           => $value
                ]
            );
        }
    }

    /**
     * @param \App\Models\User $user
     * @param string $model
     * @param string $platform
     * @param string $vendorId
     * @param string $pushToken
     */
    public function saveDevice(User $user, string $model, string $platform, string $vendorId, string $pushToken = null)
    {
        $user->devices()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id'          => $user->id,
                'model'            => $model,
                'platform'         => $platform,
                'vendor_id'        => $vendorId,
                'push_token'       => $pushToken,
                'last_accessed_at' => Carbon::now()
            ]
        );
    }
}
