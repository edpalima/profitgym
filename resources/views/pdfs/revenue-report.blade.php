<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rental Report</title>
    <style>
        :root {
            --primary-color: #f36100;
            --text-color: #333;
            --light-bg: #f9fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        p {
            text-align: center;
            margin-top: 0;
            font-size: 14px;
            color: #555;
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            height: 80px;
            filter: grayscale(100%) brightness(1.2);
        }

        .contact-info {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        th, td {
            padding: 10px 12px;
            border: 1px solid var(--border-color);
        }

        th {
            background-color: #ffece1;
            text-align: left;
            color: var(--primary-color);
        }

        td {
            color: #4a5568;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #fff2e9;
            border-top: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }

        .footer strong {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo and contact -->
        <div class="logo">
            <img src="{{ public_path('logos/profit-gym.png') }}" alt="Company Logo">
        </div>
        <div class="contact-info">
            jeremiahpanganibanr@gmail.com | +63 912 123 6182
        </div>

        <!-- Report title -->
        <h3>Rental Report</h3>
        <p>
            Report for: <strong>{{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }}</strong>
            to <strong>{{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}</strong>
        </p>

        <!-- Rentals table -->
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="text-right">Revenue (P)</th>
                </tr>
            </thead>
            <tbody>
                @php $sum = 0; @endphp
                @forelse ($revenues as $revenue)
                    @php $sum += (float) $revenue['revenue']; @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($revenue['date'])->format('F j, Y') }}</td>
                        <td class="text-right">P{{ number_format((float) $revenue['revenue_raw'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No revenue data available.</td>
                    </tr>
                @endforelse
                @if ($revenues && count($revenues))
                    <tr class="total-row">
                        <td>Total Revenue</td>
                        <td class="text-right">P{{ number_format($totalRevenue, 2) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Generated on {{ now()->format('F j, Y, g:i a') }}</p>
            <p>Prepared By: <strong>{{ $preparedBy }}</strong></p>
        </div>
    </div>
</body>
</html>
