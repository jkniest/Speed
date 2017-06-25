<?php

namespace App\Http\Controllers;

use App\Models\Server;

/**
 * Handles all requests related to server settings, etc..
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class ServerController extends Controller
{
    /**
     * Update the name of the server
     *
     * @return void
     */
    public function update()
    {
        $this->validate(request(), [
            'token' => 'required|exists:servers,token',
            'name'  => 'required'
        ]);

        tap(Server::getByToken(request('token')), function ($server) {
            $server->update(['name' => request('name')]);
        });
    }

    /**
     * Delete a given server
     *
     * @return void
     */
    public function destroy()
    {
        $this->validate(request(), [
            'token' => 'required|exists:servers,token'
        ]);

        tap(Server::getByToken(request('token')), function ($server) {
            $server->delete();
            $server->tests()->delete();
        });

        cache()->flush();
    }
}
