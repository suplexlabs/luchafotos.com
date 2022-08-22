<?php

namespace App\Models;

use App\Enums\Users;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($item) {
            $item->createDefaultNotifications();
            $item->save();
        });
        static::created(function ($item) {
            $item->last_accessed_at = Carbon::now();
            $item->createDefaultNotifications();
            $item->save();
        });
    }

    public function canAccessFilament(): bool
    {
        return true;
        return $this->isAdmin();
    }

    public function isAdmin(): bool
    {
        return $this->type == Users::ADMIN->value;
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'user_id');
    }

    public function subscribedPodcasts()
    {
        return $this->hasMany(SubscribedPodcast::class, 'user_id');
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function getNotificationsAttribute()
    {
        $notifications = [];
        $settings = $this->settings ?: $this->settings()->create();

        if ($settings->notifications->isEmpty()) {
            $this->createDefaultNotifications();
        }

        $settings->notifications->map(function ($notification) use (&$notifications) {
            $key = $notification->name;
            $notifications[$key] = ((bool) $notification->value) ?: false;
        });

        return (object) $notifications;
    }

    public function createDefaultNotifications()
    {
        /** @var \App\Models\UserSetting $settings */
        $settings = $this->settings ?: $this->settings()->create();

        if ($settings->notifications->isEmpty()) {
            $types = UserSettingNotification::getAllNotificationTypes();
            foreach ($types as $name) {
                UserSettingNotification::create([
                    'user_setting_id' => $settings->id,
                    'name'            => $name,
                    'value'           => true
                ]);
            }
        }
    }

    public function getShowSpoilersAttribute()
    {
        return $this->settings->show_spoilers;
    }
    public function getUseReaderModeAttribute()
    {
        return $this->settings->use_reader_mode;
    }
    public function getAppDarkmodeAttribute()
    {
        return $this->settings->app_dark_mode;
    }
    public function getSystemDarkModeAttribute()
    {
        return $this->settings->system_dark_mode;
    }
}
