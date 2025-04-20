<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MembershipCheckoutController extends Controller
{
    public function show(Membership $membership)
    {
        return view('pages.memberships-checkout', compact('membership'));
    }

    public function store(Request $request, Membership $membership)
    {
        $user = Auth::user();

        $startDate = Carbon::now();
        $endDate = match ($membership->duration_unit) {
            'days' => $startDate->copy()->addDays($membership->duration_value),
            'weeks' => $startDate->copy()->addWeeks($membership->duration_value),
            'months' => $startDate->copy()->addMonths($membership->duration_value),
            'years' => $startDate->copy()->addYears($membership->duration_value),
        };

        UserMembership::create([
            'user_id' => $user->id,
            'membership_id' => $membership->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'pending',
        ]);

        return redirect()->route('memberships.index')->with('success', 'Your membership request has been submitted!');
    }
}
