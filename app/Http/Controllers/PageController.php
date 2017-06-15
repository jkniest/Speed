<?php

namespace App\Http\Controllers;

use App\Services\AverageService;

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

    /**
     * Get the overview page
     *
     * @param AverageService $avg The average calculation service
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview(AverageService $avg)
    {
        $averageDownload = number_format($avg->getDown());
        $averageUpload = number_format($avg->getUp());

        $avgDownload = collect(range(0, 23))->map(function ($hour) use ($avg) {
            return $avg->getDown($hour);
        });

        $avgUpload = collect(range(0, 23))->map(function ($hour) use ($avg) {
            return $avg->getUp($hour);
        });

        return view('overview',
            compact('averageDownload', 'averageUpload', 'avgDownload', 'avgUpload'));
    }
}
