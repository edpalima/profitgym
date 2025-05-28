<div class="pt-5">
    <div class="container"> <!-- Added 'pt-4' for padding top -->
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row pt-5" id="feedback">
            <!-- Left side for contact info or any other details -->
            <div class="col-lg-6">
                <div class="section-title contact-title">
                    <span>Leave Your Feedback</span>
                    <h2>We'd Love to Hear From You</h2>
                </div>
                <div class="contact-widget">
                    <div class="cw-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Zone 5, AFP Housing </br>
                            Bulihan, Silang, Cavite</p>
                    </div>
                    <div class="cw-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>0912 123 6182</li>
                        </ul>
                    </div>
                    <div class="cw-text email">
                        <i class="fa fa-envelope"></i>
                        <p>jeremiahpanganibanr@gmail.com</p>
                    </div>
                </div>
            </div>

            <!-- Right side for the feedback form -->
            <div class="col-lg-6">
                <div class="leave-comment">
                    <form wire:submit.prevent="submit">
                        <!-- Membership Selection Dropdown -->
                        <div class="form-group">
                            <label for="membership" class="form-label color-white">Select Membership</label>
                            <select wire:model.defer="membershipId" id="membership" class="form-control">
                                <option value="">Select a membership</option>
                                @foreach ($memberships as $membership)
                                    <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                                @endforeach
                            </select>
                            @error('membershipId')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Message Input -->
                        <div class="form-group">
                            <label for="message" class="form-label color-white">Message</label>
                            <textarea wire:model.defer="message" id="message" class="form-control" rows="4"
                                placeholder="Write your feedback..."></textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Rating Input -->
                        <div class="form-group">
                            <label for="rating" class="form-label color-white">Rating</label>
                            <select wire:model.defer="rating" id="rating" class="form-control">
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
