<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::where('is_active', true)->get();
        return view('pages.memberships', compact('memberships'));
    }

    public function checkout(Membership $membership)
    {
        $userHasMembership = Auth::user()->hasMembership($membership->id);

        return view('pages.memberships-checkout', compact('membership', 'userHasMembership'));
    }
}
