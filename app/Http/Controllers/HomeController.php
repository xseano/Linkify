<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return 'no';
        }
        else
        {
            // User data
            $user = Auth::user();
            $uid = $user->id;

            // Check if the link exists on this account
            $link_exist = \DB::table('links')->where('uid', $uid)->where('url', $url);
            $link_count = count($link_exist->first());

            if ($link_count <= 0)
            {
                // Create hash
                $base = $uid.$url;
                $hash = crc32($base);

                // Store hash relational to base link
                \DB::table('links')->insert(
                    [
                        'url' => $url,
                        'hash' => $hash,
                        'uid' => $uid
                    ]
                );

                $redirect_url = url("/{$hash}");

                return $redirect_url;
            }
            else
            {
                // Return back the existing data
                $existing_link = $link_exist->first();
                $redirect_url = url("/{$existing_link->hash}");

                return $redirect_url;
            }

        }
    }

    public function processRedirectURL($hash)
    {
        // Check if hash exists
        $links = \DB::table('links');
        $link = $links->where('hash', $hash)->first();
        $link_count = count($link);

        if ($link_count <= 0)
        {
            // Redirect doesn't exist, return 404
            return abort(404);
        }
        else
        {
            // Redirect is valid, proceed
            return redirect($link->link);
        }

    }
}
