<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function parseURL(Request $request)
    {
        // Checks the data is not malformed or tampered with from the request's perspective
        $this->validate($request,
            [
                'link' => 'required'
            ]
        );
        $url = $request->link;

        // Check the link is a valid URL
        // NOTE: this ignores protocol
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE)
        {
            // TODO: notify user
            return 'invalid link';
        }
        else
        {
            // TODO: continue on to check / store the URL
            return 'valid link';
        }
    }
}
