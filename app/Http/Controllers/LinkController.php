<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Link;

class LinkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function processRedirectURL($token)
    {
        // Check if token exists
        $link = Link::whereToken($token);
        $link_count = count($link->first());

        if ($link_count <= 0)
        {
            // Redirect doesn't exist, return 404
            return abort(404);
        }
        else
        {
            // Increment the amount of times this link has been used
            $link->increment('count');

            // Redirect is valid, proceed
            return redirect($link->first()->link);
        }

    }
}
