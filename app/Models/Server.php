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
     * @return int
     */
    public function getAverageDownload()
    {
        return $this->getAverage('down');
    }

    /**
     * Get the average upload speed of this server
     *
     * @return int
     */
    public function getAverageUpload()
    {
        return $this->getAverage('up');
    }

    /**
     * Get the rounded average value of a given field ($field_speed)
     *
     * @param string $field The field name
     *
     * @return int
     */
    private function getAverage(string $field)
    {
        $key = $this->getCacheKey($field);

        return Cache::remember($key, 60, function () use ($field) {
            return round(
                $this->tests->pluck("{$field}_speed")
                    ->avg()
            );
        });
    }

    /**
     * Get the key for caching based on the server id and field name
     *
     * @param string $field The field name
     *
     * @return string
     */
    private function getCacheKey(string $field)
    {
        return "average-{$this->id}-{$field}";
    }
}
