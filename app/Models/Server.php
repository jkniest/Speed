<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
     * Get the average download speed of all servers (optional by hour)
     *
     * @param null|int $hour The specific hour
     *
     * @return int
     */
    public static function getAverageDown($hour = null)
    {
        return static::getAverage('down', $hour);
    }

    /**
     * Get the average up speed (optional by hour)
     *
     * @param null|int $hour The specific hour
     *
     * @return int
     */
    public static function getAverageUp($hour = null)
    {
        return static::getAverage('up', $hour);
    }

    /**
     * Get the average speed by a field name ($key_speed)
     *
     * @param string   $field The field name (e.g. up or down)
     * @param null|int $hour  The specific hour
     *
     * @return int
     */
    protected static function getAverage(string $field, $hour)
    {
        $key = "average-{$field}" . (($hour != null) ? '-' . $hour : '');

        return Cache::remember($key, 60, function () use ($hour, $field) {
            return DB::table('tests')->get()
                ->filter(function ($test) use ($hour) {
                    return ($hour == null) ? true : (new Carbon($test->created_at))->hour == $hour;
                })->pluck("{$field}_speed")
                ->avg();
        });
    }
}
