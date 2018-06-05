<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            // user exists, perform checks
            $user = Auth::user();

            if ($user)
            {
                return redirect()->intended('home');
            }
        }
        else
        {
            // user doesn't exist
            $response = 'The credentials you provided did not match any accounts.';
            return redirect()->intended('login')->withErrors(['unmet_requisites' => trans($response)]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('login');
    }

    public function showLoginForm()
    {
        if (Auth::check())
        {
            // user is already authenticated
            return redirect()->intended('home');
        }
        else
        {
            return view('auth.login');
        }
    }
}
