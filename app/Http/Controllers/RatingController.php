<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\TrainerRating;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class RatingController extends Controller
{
    public function printAllDataRatings()
    {
        $ratings = TrainerRating::with(['user', 'trainer'])->get();

        $user = auth()->user();
        $printedBy = $user ? htmlspecialchars($user->name) : 'Guest';
        $printedAt = now()->format('F j, Y \a\t g:i A');

        // Calculate statistics
        $totalRatings = $ratings->count();
        $averageRating = $ratings->avg('rating');
        $recommendationRate = $totalRatings > 0 ? ($ratings->where('recommend', true)->count() / $totalRatings * 100) : 0;

        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ratings Report | Profit Gym Tones</title>
            <link rel="icon" type="image/png" href="' . asset('images/header/favicon.png') . '">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="' . asset('css/print.css') . '">
            <style>
                .badge {
                    display: inline-block;
                    padding: 0.25em 0.4em;
                    font-size: 75%;
                    font-weight: 700;
                    line-height: 1;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: baseline;
                    border-radius: 0.25rem;
                }
                .badge-1 { background-color: #dc3545; color: white; }
                .badge-2 { background-color: #dc3545; color: white; }
                .badge-3 { background-color: #ffc107; color: black; }
                .badge-4 { background-color: #28a745; color: white; }
                .badge-5 { background-color: #28a745; color: white; }
                .summary-row { background-color: #f8f9fa; font-weight: bold; }
                .amount { text-align: right; }
                .date { white-space: nowrap; }
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
                    <h1>PROFIT GYM TONE MANAGEMENT</h1>
                    <p>jeremiahpanganibanr@gmail.com | +63 912 123 6182</p>
                </div>

                <h2 class="report-title">RATINGS REPORT</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Rating ID</th>
                            <th>User</th>
                            <th>Trainer</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                            <th>Recommended</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($ratings as $rating) {
            $ratingBadge = match ($rating->rating) {
                1 => '<span class="badge badge-1">1 Star</span>',
                2 => '<span class="badge badge-2">2 Stars</span>',
                3 => '<span class="badge badge-3">3 Stars</span>',
                4 => '<span class="badge badge-4">4 Stars</span>',
                5 => '<span class="badge badge-5">5 Stars</span>',
                default => '<span class="badge">N/A</span>',
            };

            // Build trainer name from individual components
            $trainerName = '';
            if ($rating->trainer) {
                $trainerName = $rating->trainer->first_name;
                if ($rating->trainer->middle_name) {
                    $trainerName .= ' ' . $rating->trainer->middle_name;
                }
                $trainerName .= ' ' . $rating->trainer->last_name;
            }

            $html .= '<tr>
                <td>' . $rating->id . '</td>
                <td>' . ($rating->user?->anonymized_name ?? 'anonymous') . '</td>
                <td>' . ($rating->trainer ? htmlspecialchars(trim($trainerName)) : 'N/A') . '</td>
                <td>' . $ratingBadge . '</td>
                <td>' . htmlspecialchars(substr($rating->feedback, 0, 50)) . (strlen($rating->feedback) > 50 ? '...' : '') . '</td>
                <td>' . ($rating->recommend ? 'Yes' : 'No') . '</td>
                <td class="date">' . $rating->created_at->format('M j, Y g:i A') . '</td>
            </tr>';
        }

        // Add summary row
        $html .= '<tr class="summary-row">
                <td colspan="3"><strong>SUMMARY</strong></td>
                <td><strong>Average: ' . number_format($averageRating, 1) . ' Stars</strong></td>
                <td><strong>Total Ratings: ' . $totalRatings . '</strong></td>
                <td><strong>Recommendation Rate: ' . number_format($recommendationRate, 1) . '%</strong></td>
                <td></td>
            </tr>';

        $html .= '</tbody>
                </table>

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