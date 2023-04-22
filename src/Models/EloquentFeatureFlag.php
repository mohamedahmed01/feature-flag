<?php
namespace Mohamedahmed01\FeatureFlag\Models;

use Illuminate\Database\Eloquent\Model;
use Mohamedahmed01\FeatureFlag\Interfaces\FeatureFlagInterface;
use Mohamedahmed01\FeatureFlag\Notifications\ExpiredFeatureFlagNotification;
use Illuminate\Support\Facades\Notification;

class EloquentFeatureFlag extends Model implements FeatureFlagInterface
{
    protected $table = 'feature_flags';
    protected $casts = [
        'audience' => 'array',
    ];
    protected $fillable = ['name', 'description', 'enabled', 'audience', 'percentage', 'finish_date'];
    protected $dates = [
        'finish_date',
    ];
    /**
     * Get the unique name of the feature flag.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the description of the feature flag.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Check if the feature flag is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        if ($this->enabled && $this->finish_date && $this->finish_date->isPast()) {
            $action = config('feature_flag.finish_date_action');
            if ($action == 'exception') {
                throw new \Exception('Feature flag ' . $this->name . ' has expired');
            } else {
                $this->notifyIfExpired();
            }
        }

        return $this->enabled;
    }

    public function notifyIfExpired()
    {
        if ($this->enabled && $this->finish_date && $this->finish_date->isPast()) {
            $email = config('feature_flag.notification_email');
            Notification::route('mail', $email)
                ->notify(new ExpiredFeatureFlagNotification($this));
        }
    }

    /**
     * Check if the feature flag is targeted to specific audience.
     *
     * @return bool
     */
    public function isTargeted(): bool
    {
        return (bool) $this->audience;
    }

    /**
     * Get the audience of the feature flag.
     *
     * @return array|null
     */
    public function getAudience(): ?array
    {
        return json_decode($this->audience, true);
    }

    /**
     * Set the status of the feature flag.
     *
     * @param bool $enabled
     *
     * @return void
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;

        $this->save();
    }

    /**
     * Set the audience of the feature flag.
     *
     * @param array|null $audience
     *
     * @return void
     */
    public function setAudience(?array $audience): void
    {
        $this->audience = json_encode($audience);

        $this->save();
    }


    public function getAudienceByAttribute(string $key, string $value): array
    {
        return $this->audience()->where($key, $value)->pluck('id')->toArray();
    }

    public function audience()
    {
        return $this->belongsToMany(User::class);
    }

    public function isEnabledForUser($user): bool
    {
        $hash = md5($user->id);
        $decimal = hexdec(substr($hash, 0, 8)) / pow(16, 8);
        return $decimal <= ($this->percentage / 100);
    }
}