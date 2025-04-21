<?php

namespace App\Http\Controllers;

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
}
