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
     * Store a new server inside the database.
     *
     * @return void
     */
    public function store()
    {
        $this->validate(request(), [
            'name'  => 'required',
            'token' => 'required|exists:users'
        ]);

        Server::create([
            'name'  => request('name'),
            'token' => str_random()
        ]);
    }

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
