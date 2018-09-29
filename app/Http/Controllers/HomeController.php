<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Link;
use App\URLToken;

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
        $this->tokenizer = new URLToken('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
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
            $link_exist = Link::whereUid($uid);
            $link_exist = $link_exist->where('link', $url);
            $link_count = count($link_exist->first());

            if ($link_count <= 0)
            {
                // Create hash and token
                $base = $uid.$url;
                $hash = crc32($base);
                $token = $this->tokenizer->encode($hash);

                // Store token relational to base link
                Link::insert(
                    [
                        'link' => $url,
                        'token' => $token,
                        'uid' => $uid
                    ]
                );

                $redirect_url = url("/{$token}");
                $response = 'Success! You may now use the shortened link at: ' . $redirect_url;

                return redirect()->intended('home')->withErrors(['link_success' => trans($response)]);
            }
            else
            {
                // Return back the existing data
                $existing_link = $link_exist->first();
                $token = $existing_link->token;
                $redirect_url = url("/{$token}");

                $response = 'You have already registered this link, visit it at: ' . $redirect_url;

                return redirect()->intended('home')->withErrors(['link_success' => trans($response)]);
            }

        }
    }

    public function getAccount()
    {
        $uid = Auth::user()->id;
        $linkData = Link::whereUid($uid)->orderBy('date', 'desc')->paginate(15);

        return view('account')->with('links', $linkData);
    }
}
