<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function termsAndConditions()
    {
        return view('pages.terms-and-conditions');
    }

    public function account()
    {
        $user = auth()->user();
        // dd($user);
        return view('pages.account', compact('user'));
    }
}
