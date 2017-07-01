<?php

namespace App\Services;

use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

/**
 * This service can return the average download or upload speed based on a few parameters like the
 * specific hour.
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class AverageService
{
    /**
     * All speedtests
     *
     * @var Collection
     */
    private $tests;

    /**
     * AverageService constructor.
     */
    public function __construct()
    {
        $this->tests = Test::all();
    }

    /**
     * Get the average download speed of all servers
     *
     * @param null|int $hour The specific hour
     *
     * @return int
     */
    public function getDown($hour = null)
    {
        return $this->get('down', $hour);
    }

    /**
     * Get the average upload speed of all servers
     *
     * @param null|int $hour The specific hour
     *
     * @return int
     */
    public function getUp($hour = null)
    {
        return $this->get('up', $hour);
    }

    /**
     * Get the average speed of all servers by a field name ($key_speed)
     *
     * @param string   $field The field name (e.g. up or down)
     * @param null|int $hour  The specific hour
     *
     * @return int
     */
    protected function get(string $field, $hour)
    {
        return round(
            $this->tests->filter(function ($test) use ($hour) {
                return (is_null($hour)) ? true : $test->created_at->hour == $hour;
            })->pluck("{$field}_speed")
                ->avg()
        );
    }
}
