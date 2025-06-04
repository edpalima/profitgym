<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.products');
    }

    public function printAllDataProduct()
    {
        $products = Product::with('category')->get();

        $user = auth()->user();
        $printedBy = $user ? htmlspecialchars($user->name) : 'Guest';
        $printedAt = now()->format('F j, Y \a\t g:i A');

        // Calculate totals
        $totalProducts = $products->count();
        $totalActive = $products->where('is_active', true)->count();
        $totalStock = $products->sum('stock_quantity');
        $totalValue = $products->sum(function($product) {
            return $product->price * $product->stock_quantity;
        });

        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Products Report | Profit Gym Tone</title>
            <link rel="icon" type="image/png" href="' . asset('logos/profit-gym.png') . '">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="' . asset('css/print.css') . '">
            <style>
                .amount { text-align: right; }
                .product-image {
                    width: 50px;
                    height: 50px;
                    object-fit: cover;
                    border-radius: 4px;
                }
                .summary-box {
                    display: flex;
                    justify-content: space-around;
                    margin: 1rem 0;
                    padding: 1rem;
                    background-color: #f8fafc;
                    border-radius: 0.5rem;
                }
                .summary-item {
                    text-align: center;
                }
                .summary-count {
                    font-size: 1.5rem;
                    font-weight: bold;
                }
            </style>
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() {
                        window.close();
                    }, 1000);
                };
            </script>
        </head>
        <body>
            <div class="document">
                <div class="header">
                    <img src="' . asset('logos/profit-gym.png') . '" alt="Company Logo" class="header-logo">
                    <p>jeremiahpanganibanr@gmail.com | +63 912 123 6182</p>
                </div>

                <h2 class="report-title">PRODUCTS INVENTORY REPORT</h2>


                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($products as $product) {
            $statusBadge = $product->is_active 
                ? '<span class="badge badge-active">ACTIVE</span>'
                : '<span class="badge badge-inactive">INACTIVE</span>';

            $preorderBadge = $product->allows_preorder
                ? '<span class="badge badge-preorder">ALLOWED</span>'
                : '<span class="badge">NOT ALLOWED</span>';

            $imageHtml = $product->image 
                ? '<img src="' . asset('storage/' . $product->image) . '" class="product-image">'
                : '<div class="product-image" style="background:#eee;display:flex;align-items:center;justify-content:center;">N/A</div>';

            $html .= '<tr>
                <td>' . $imageHtml . '</td>
                <td>' . htmlspecialchars($product->name) . '</td>
                <td>' . ($product->category->name ?? 'N/A') . '</td>
                <td class="amount">₱' . number_format($product->price, 2) . '</td>
                <td>' . $product->stock_quantity . '</td>
            </tr>';
        }

        $html .= '</tbody>
                </table>
               <div class="summary-box">
                    <div class="summary-item">
                        <div class="summary-count">' . $totalProducts . '</div>
                        <div>Total Products</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-count">' . $totalActive . '</div>
                        <div>Active Products</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-count">' . $totalStock . '</div>
                        <div>Total Stock</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-count">₱' . number_format($totalValue, 2) . '</div>
                        <div>Total Inventory Value</div>
                    </div>
                </div>
                <div class="footer">
                    <p>Generated by ' . $printedBy . ' on ' . $printedAt . '</p>
                     <p>Confidential Document • © ' . date('Y') . ' Profit Gym Tone Management</p>
                </div>
            </div>
        </body>
        </html>';

        return response($html);
    }
}