<section class="team-section team-page spad ">
    <div class="container dark" style="color: white">
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="team-title">
                    <div class="section-title">
                        <span>My Orders</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="chart-table">
                <table id="orders-table" class="table table-bordered table-striped align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <!-- Display Order Items -->
                                    <ul style="padding-left: 20px;">
                                        @foreach ($order->orderItems as $orderItem)
                                            <li>
                                                {{ $orderItem->product->name }} ({{ $orderItem->quantity }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        bg-{{ $order->status === 'PENDING'
                                            ? 'warning'
                                            : ($order->status === 'COMPLETED'
                                                ? 'success'
                                                : ($order->status === 'REJECTED' || $order->status === 'CANCELLED'
                                                    ? 'danger'
                                                    : 'secondary')) }} text-dark">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No orders found.
                                    <a href="{{ route('products') }}" class="primary-color">Browse Products</a>
                                    to place an order.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
