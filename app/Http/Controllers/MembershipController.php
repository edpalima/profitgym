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
        if (!Auth::check() || Auth::user()->role !== 'MEMBER') {
            return redirect()->route('login');
        }

        $userHasMembership = Auth::user()->hasMembership($membership->id);
        return view('pages.memberships-checkout', compact('membership', 'userHasMembership'));
    }

    public function showUpgradeForm(Membership $membership)
    {
        $user = auth()->user();
        $currentMembership = $user->activeMembership();

        // Verify the user can upgrade to this membership
        if (!$currentMembership) {
            return redirect()->route('memberships.index')
                ->with('error', 'You need an active membership to upgrade');
        }

        if ($membership->price <= $currentMembership->membership->price) {
            return redirect()->route('memberships.index')
                ->with('error', 'You can only upgrade to a higher-tier membership');
        }

        return view('memberships.upgrade', [
            'currentMembership' => $currentMembership,
            'newMembership' => $membership
        ]);
    }

    // In your controller where you handle the upgrade submission

    public function processUpgrade(Request $request)
    {
        $request->validate([
            'new_membership_id' => 'required|exists:memberships,id'
        ]);

        $user = auth()->user();
        $currentMembership = $user->activeMembership();
        $newMembership = Membership::find($request->new_membership_id);

        // Validate the upgrade
        if (!$currentMembership) {
            return back()->with('error', 'No active membership found');
        }

        if ($newMembership->price <= $currentMembership->membership->price) {
            return back()->with('error', 'Invalid upgrade selection');
        }

        // Process the upgrade (example logic)
        try {
            // Deactivate current membership
            $currentMembership->update(['is_active' => false]);
            
            // Create new membership
            $user->memberships()->create([
                'membership_id' => $newMembership->id,
                'start_date' => now(),
                'end_date' => now()->add($newMembership->duration_value, $newMembership->duration_unit),
                'status' => 'APPROVED',
                'is_active' => true
            ]);

            return redirect()->route('memberships.index')
                ->with('success-member', 'Membership upgraded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing upgrade: '.$e->getMessage());
        }
    }
}