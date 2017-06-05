<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Test;
use Carbon\Carbon;

/**
 * Handle all api requests related to the speed tests
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class TestController extends Controller
{
    /**
     * Store a new test result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate(request(), [
            'token' => 'required|exists:servers',
            'down'  => 'required',
            'up'    => 'required'
        ]);

        $server = Server::getByToken(request('token'));

        Test::create([
            'server_id'  => $server->id,
            'down_speed' => request('down'),
            'up_speed'   => request('up')
        ]);

        $server->last_test = Carbon::now();
        $server->save();

        return response()->json(['success' => 'Test result saved']);
    }
}
