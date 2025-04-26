<section class="team-section team-page spad">
    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="team-title">
                    <div class="section-title">
                        <span>My Feedbacks</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="chart-table">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Membership</th>
                            <th>Message</th>
                            <th>Rating</th>
                            <th>Is Approved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->membership?->name ?? 'No Membership' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($feedback->message, 100) }}</td>
                                <td>
                                    @for ($i = 0; $i < $feedback->rating; $i++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor
                                    @for ($i = $feedback->rating; $i < 5; $i++)
                                        <i class="fa fa-star-o text-muted"></i>
                                    @endfor
                                </td>
                                <td>{{ $feedback->is_approved ? 'Yes' : 'No' }}</td>
                                <td>
                                    <button wire:click="delete({{ $feedback->id }})" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this feedback?')">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No feedback available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row mb-4">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('memberships.index') }}" class="primary-btn btn-normal appoinment-btn" >
                            + Create Feedback
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
