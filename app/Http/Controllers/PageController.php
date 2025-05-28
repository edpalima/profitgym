<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function termsAndConditions()
    {
        return view('pages.terms-and-conditions');
    }

    public function account()
    {
        if (!Auth::check() || Auth::user()->role !== 'MEMBER') {
            return redirect()->route('login');
        }

        $user = auth()->user();
        // dd($user);
        // return view('pages.account', compact('user'));

        return view('pages.profile', compact('user'));
    }

    public function products()
    {
        if (!Auth::check() || Auth::user()->role !== 'MEMBER') {
            return redirect()->route('login');
        }

        return view('pages.products');
    }

    public function product($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.product-details', compact('product'));
    }
    public function gallery()
    {
        $galleries = Gallery::where('is_active', true)
            ->inRandomOrder()
            ->get(); // Fetch 8 random active galleries

        return view('pages.gallery', compact('galleries'));
    }

    public function feedback()
    {
        if (!auth()->check()) {
            return redirect('/');
        }

        $feedbacks = Feedback::with('user')
            ->where('is_approved', true)
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pages.feedbacks', compact('feedbacks'));
    }
    public function orders()
    {
        if (!Auth::check() || Auth::user()->role !== 'MEMBER') {
            return redirect()->route('login');
        }

        return view('pages.orders');
    }
}
