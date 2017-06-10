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
     * PageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('overview');
    }

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

    public function overview()
    {
        return view('overview');
    }
}
