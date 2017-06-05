<?php

namespace App\Http\Controllers;

/**
 * Handle all requests related to non-resourceful pages like the frontpage
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class PageController extends Controller
{
    /**
     * Redirect the user, based on their authentication status to the login page
     * or the overview page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('overview');
        }

        return redirect()->route('login');
    }
}
