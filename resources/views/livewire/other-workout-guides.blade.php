<div class="so-latest">
    <h5 class="title">Other Workout Guides</h5>

    @if ($guides->isNotEmpty())
        @php $first = $guides->first(); @endphp

        {{-- Large feature card --}}
        <div class="latest-large set-bg" data-setbg="{{ asset('storage/' . $first->featured_photo) }}">
            <div class="ll-text">
                <h5>
                    <a href="{{ route('workout-guide.show', $first->id) }}">
                        {{ \Illuminate\Support\Str::limit($first->title, 60) }}
                    </a>
                </h5>
                <ul>
                    <li>{{ $first->created_at->format('M d, Y') }}</li>
                </ul>
            </div>
        </div>

        {{-- Remaining cards --}}
        @foreach ($guides->skip(1) as $guide)
            <div class="latest-item">
                <div class="li-pic">
                    <a href="{{ route('workout-guide.show', $guide->id) }}">
                        <img src="{{ asset('storage/' . $guide->featured_photo) }}" alt="" style="height: 100%; object-fit: cover;">
                    </a>
                </div>
                <div class="li-text">
                    <h6>
                        <a href="{{ route('workout-guide.show', $guide->id) }}">
                            {{ \Illuminate\Support\Str::limit($guide->title, 50) }}
                        </a>
                    </h6>
                    <span class="li-time">{{ $guide->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endforeach
    @else
        <p>No other workout guides available.</p>
    @endif
</div>
