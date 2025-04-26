<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Product;
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

    public function products()
    {
        return view('pages.products');
    }

    public function product($id)
    {
        $product = Product::findOrFail($id);

        return view('pages.product-details', compact('product'));
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
}
