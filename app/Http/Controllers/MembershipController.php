<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::where('is_active', true)->get();
        return view('pages.memberships', compact('memberships'));
    }
}
