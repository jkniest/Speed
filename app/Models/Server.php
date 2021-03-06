<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Representation of the server object
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'token'];

    /**
     * Find a server by it's token
     *
     * @param string $token The servers' token
     *
     * @return Server
     */
    public static function getByToken(string $token)
    {
        return static::whereToken($token)->firstOrFail();
    }

    /**
     * Return all related tests
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    /**
     * Get the average download speed of this server
     *
     * @param int|null $hour The specific hour
     *
     * @return int
     */
    public function getAverageDownload($hour = null)
    {
        return $this->getAverage('down', $hour);
    }

    /**
     * Get the average upload speed of this server
     *
     * @param int|null $hour The specific hour
     *
     * @return int
     */
    public function getAverageUpload($hour = null)
    {
        return $this->getAverage('up', $hour);
    }

    /**
     * Return the average download speed grouped by hour (0 - 23)
     *
     * @return array
     */
    public function getAverageDownloadArray()
    {
        return collect(range(0, 23))
            ->map(function ($hour) {
                return $this->getAverageDownload($hour);
            })->toArray();
    }

    /**
     * Return the average upload speed grouped by hour (0 - 23)
     *
     * @return array
     */
    public function getAverageUploadArray()
    {
        return collect(range(0, 23))
            ->map(function ($hour) {
                return $this->getAverageUpload($hour);
            })->toArray();
    }

    /**
     * Get the rounded average value of a given field ($field_speed)
     *
     * @param string   $field The field name
     * @param int|null $hour  The specific hour
     *
     * @return int
     */
    private function getAverage(string $field, $hour = null)
    {
        return round(
            $this->tests->filter(function ($test) use ($hour) {
                return (is_null($hour)) ? true : $hour == $test->created_at->hour;
            })->pluck("{$field}_speed")
                ->avg()
        );
    }
}
