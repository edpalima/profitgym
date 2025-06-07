<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    protected function authenticated(Request $request, $user)
    {
        if (session()->has('rate_redirect')) {
            $redirectData = session('rate_redirect');
            session()->forget('rate_redirect');
            
            return redirect()->to($redirectData['intended'])
                ->with('show_rate_modal', $redirectData['trainer_id']);
        }

        return redirect()->intended($this->redirectPath());
    }
}
