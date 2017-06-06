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
        $key = 'average-down' . (($hour != null) ? '-' . $hour : '');

        return Cache::remember($key, 60, function () use ($hour) {
            return DB::table('tests')
                ->get()
                ->filter(function ($test) use ($hour) {
                    if ($hour == null) {
                        return true;
                    } else {
                        return (new Carbon($test->created_at))->hour == $hour;
                    }
                })->pluck('down_speed')
                ->avg();
        });
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
        $key = 'average-up' . (($hour != null) ? '-' . $hour : '');

        return Cache::remember($key, 60, function () use ($hour) {
            return DB::table('tests')
                ->get()
                ->filter(function ($test) use ($hour) {
                    if ($hour == null) {
                        return true;
                    } else {
                        return (new Carbon($test->created_at))->hour == $hour;
                    }
                })->pluck('up_speed')
                ->avg();
        });
    }
}
