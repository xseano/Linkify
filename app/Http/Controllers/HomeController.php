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
            // URL is invalid
            $response = 'The URL "' . $redirect_url . '" is invalid, please try another or contact support.';

            return redirect()->intended('home')->withErrors(['link_error' => trans($response)]);
        }
        else
        {
            // User data
            $user = Auth::user();
            $uid = $user->id;

            // Check if the link exists on this account
            $link_exist = \DB::table('links')->where('uid', $uid)->where('link', $url);
            $link_count = count($link_exist->first());

            if ($link_count <= 0)
            {
                // Create hash
                $base = $uid.$url;
                $hash = crc32($base);

                // Store hash relational to base link
                \DB::table('links')->insert(
                    [
                        'link' => $url,
                        'hash' => $hash,
                        'uid' => $uid
                    ]
                );

                $redirect_url = url("/{$hash}");
                $response = 'Success! You may now use the shortened link at: ' . $redirect_url;

                return redirect()->intended('home')->withErrors(['link_success' => trans($response)]);
            }
            else
            {
                // Return back the existing data
                $existing_link = $link_exist->first();
                $redirect_url = url("/{$existing_link->hash}");

                $response = 'You have already registered this link, visit it at: ' . $redirect_url;

                return redirect()->intended('home')->withErrors(['link_success' => trans($response)]);
            }

        }
    }

    public function processRedirectURL($hash)
    {
        // Check if hash exists
        $links = \DB::table('links');
        $link = $links->where('hash', $hash);
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

    public function getAccount()
    {
        $uid = Auth::user()->id;
        $linkData = \DB::table('links')->where('uid', $uid)->orderBy('date', 'desc')->paginate(15);

        return view('account')->with('links', $linkData)
    }
}
