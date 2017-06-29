<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Representation of a speed test
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class Test extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['server_id', 'up_speed', 'down_speed'];
}
