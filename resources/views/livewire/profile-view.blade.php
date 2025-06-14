<div>
    <!-- Account Info -->
    <section class="team-section team-page spad" style="padding-top: 50px">
        <div class="container">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row g-4">
                <!-- Personal Info -->
                <div class="col-lg-8">
                    <div class="card p-4 team-section border-gray">
                        <h5 class="text-white">Personal Information</h5>
                        <p class="text-muted small">Your profile details and contact information</p>
                        <div class="d-flex align-items-center mb-4">
                            <div class="profile-icon me-3">
                                @if ($user->getFilamentAvatarUrl())
                                    <img src="{{ $user->getFilamentAvatarUrl() }}" class="profile-img"
                                        alt="Profile Image">
                                @endif
                            </div>
                            <div class="pl-2">
                                <h5 class="mb-0 text-white">{{ $user->fullName }}</h5>
                                <small class="text-muted">
                                    {{ ucfirst($user->latestMembership()->membership->name ?? '') }}
                                </small>
                                <div class="mt-1">
                                    @if ($user->hasActiveMembership())
                                        <span class="badge bg-success text-dark">Active</span>
                                    @elseif ($user->hasUpcomingApprovedMembership())
                                        <span class="badge bg-info text-dark">Upcoming</span>
                                    @elseif ($user->hasPendingMembership())
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($user->hasExpiredMembership())
                                        <span class="badge bg-secondary">Inactive</span>
                                    @elseif ($user->hasInactiveMembership())
                                        <span class="badge bg-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Member</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Email Address</p>
                                <p><i class="bi bi-envelope"></i> {{ $user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Contact Number</p>
                                <p><i class="bi bi-telephone"></i> {{ $user->phone_number ?? 'Not Provided' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Address</p>
                                <p><i class="bi bi-geo-alt"></i> {{ $user->address ?? 'Not Provided' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Date of Birth</p>
                                <p><i class="bi bi-calendar-heart"></i> {{ $user->birth_date }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Weight</p>
                                <p><i class="bi bi-speedometer2"></i>
                                    {{ $user->weight }}{{ $user->weight_unit }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Height</p>
                                <p><i class="bi bi-arrows-collapse-vertical"></i>
                                    {{ $user->height }}{{ $user->height_unit }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Joined Date</p>
                                <p><i class="bi bi-calendar"></i> {{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-light mt-3" wire:click="showEditProfileModal">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </button>
                        @if ($latestMembership)
                            <button class="btn btn-dark mt-2 text-white" wire:click="showMembershipModal">
                                <i class="bi bi-box-arrow-up-right"></i> Membership Information
                            </button>

                            @if ($showModal)
                                <div class="modal fade show d-block" id="membershipModal" tabindex="-1"
                                    aria-labelledby="membershipModalLabel" aria-modal="true"
                                    style="background-color: rgba(0, 0, 0, 0.8);">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content bg-dark text-white border-light">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="membershipModalLabel">Membership History
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    wire:click="closeModal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" class="form-control mb-3"
                                                    placeholder="Search membership..."
                                                    wire:model.debounce.300ms.live="search" />

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-dark">
                                                        <thead class="table-light text-dark">
                                                            <tr>
                                                                <th>Type</th>
                                                                <th>Description</th>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                                <th>Date Submitted</th>
                                                                <th>Price</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($memberships as $membership)
                                                                <tr>
                                                                    <td>{{ $membership->membership->name }}</td>
                                                                    <td
                                                                        style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                        {{ $membership->membership->description }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($membership->start_date)->format('F d, Y') }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($membership->end_date)->format('F d, Y') }}
                                                                    </td>
                                                                    <td>{{ \Carbon\Carbon::parse($membership->created_date)->format('F d, Y h:i A') }}
                                                                    </td>
                                                                    <td>₱{{ number_format($membership->membership->price, 2) }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($membership->is_active && now()->between($membership->start_date, $membership->end_date) && $membership->status === 'APPROVED')
                                                                            <span
                                                                                class="badge bg-success text-dark">Active</span>
                                                                        @elseif ($membership->status === 'APPROVED' && now()->lt($membership->start_date))
                                                                            <span
                                                                                class="badge bg-info text-dark">Upcoming</span>
                                                                        @elseif ($membership->status === 'PENDING')
                                                                            <span
                                                                                class="badge bg-warning text-dark">Pending</span>
                                                                        @elseif ($membership->status === 'REJECTED')
                                                                            <span
                                                                                class="badge bg-secondary text-dark">Rejected</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-secondary">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">No
                                                                        memberships found.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                {{ $memberships->links() }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    wire:click="closeModal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Member Stats -->
                <div class="col-lg-4">
                    <div class="card p-4 team-section border-gray">
                        @if ($latestMembership)
                            <h5 class="text-white">Member Stats</h5>
                            <p class="text-muted small">Your membership information</p>
                            <div class="mb-2">
                                <p class="mb-1 fw-bold">{{ $latestMembership->membership->name }}
                                    <span class="text-muted">
                                        @if ($latestMembership->is_active && now()->between($latestMembership->start_date, $latestMembership->end_date) && $latestMembership->status === 'APPROVED')
                                            <span class="badge bg-success text-dark">Active</span>
                                        @elseif ($latestMembership->status === 'APPROVED' && now()->lt($latestMembership->start_date))
                                            <span class="badge bg-info text-dark">Upcoming</span>
                                        @elseif ($latestMembership->status === 'PENDING')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($latestMembership->status === 'REJECTED')
                                            <span class="badge bg-secondary text-dark">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary text-dark">Inactive</span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <p>Start Date: {{ \Carbon\Carbon::parse($latestMembership->start_date)->format('F d, Y') }}
                            </p>
                            <p>End Date: {{ \Carbon\Carbon::parse($latestMembership->end_date)->format('F d, Y') }}</p>
                            <div class="mt-3">
                                <p>Benefits Overview :
                                    <span>{{ $latestMembership->membership->description }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if ($showEditModal)
            <!-- Edit Profile Modal -->
            <div class="modal fade show d-block" tabindex="-1" role="dialog" style="display:block;"
                wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
                    <div class="modal-content bg-dark text-white border-light"
                        style="background-color: rgba(0, 0, 0, 0.8);">
                        <div class="modal-header">
                            <h5>Edit Profile</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('showEditModal', false)"></button>
                        </div>
                        <div class="modal-body" style="max-height: 90vh; overflow-y: auto;">
                            <form wire:submit.prevent="updateProfile">
                                {{-- Section: Personal Information --}}
                                <h5 class="text-uppercase mb-3">Personal Information</h5>
                                <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Current / Preview</label>
                                        <div>
                                            @if ($this->photoPreview)
                                                <!-- Display the preview image -->
                                                <img src="{{ $this->photoPreview }}" alt="Photo Preview"
                                                    class="img-thumbnail" style="max-height: 150px; cursor: pointer;"
                                                    onclick="document.getElementById('photo').click();">
                                            @else
                                                <span class="text-muted">No photo available</span>
                                            @endif
                                        </div>

                                        <!-- Hidden file input -->
                                        <div class="mt-2">
                                            <input type="file" id="photo" wire:model="photo" class="d-none"
                                                accept="image/*" onchange="previewImage(event)">
                                            @error('photo')
                                                <span class="text-danger fst-italic">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="first_name">First Name</label>
                                        <input id="first_name" wire:model.defer="first_name" type="text"
                                            class="form-control form-control-sm">
                                        @error('first_name')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="middle_name">Middle Name</label>
                                        <input id="middle_name" wire:model.defer="middle_name" type="text"
                                            class="form-control form-control-sm">
                                        @error('middle_name')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="last_name">Last Name</label>
                                        <input id="last_name" wire:model.defer="last_name" type="text"
                                            class="form-control form-control-sm">
                                        @error('last_name')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Section: Contact Information --}}
                                <h5 class="text-uppercase mt-4 mb-3">Contact Information</h5>
                                <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="phone_number">Phone Number</label>
                                        <input id="phone_number" wire:model.defer="phone_number" type="text"
                                            class="form-control form-control-sm" pattern="^\d{11}$"
                                            placeholder="09123456789" value="09">
                                        @error('phone_number')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="birth_date">Birth Date</label>
                                        <input id="birth_date" wire:model.defer="birth_date" type="date"
                                            class="form-control form-control-sm">
                                        @error('birth_date')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="address">Address</label>
                                        <textarea id="address" wire:model.defer="address" class="form-control form-control-sm" rows="2"></textarea>
                                        @error('address')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Section: Physical Information --}}
                                <h5 class="text-uppercase mt-4 mb-3">Physical Information</h5>
                                <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="weight">Weight (kg)</label>
                                        <input id="weight" wire:model.defer="weight" type="number"
                                            step="0.1" class="form-control form-control-sm">
                                        @error('weight')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="height">Height (cm)</label>
                                        <input id="height" wire:model.defer="height" type="number"
                                            step="0.1" class="form-control form-control-sm">
                                        @error('height')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Section: Security --}}
                                <h5 class="text-uppercase mt-4 mb-3">Credential</h5>
                                <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input id="email" wire:model.defer="email" type="email"
                                            class="form-control form-control-sm" readonly>
                                        @error('email')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="password">New Password</label>
                                        <div x-data="{ show: false }"
                                            class="d-flex align-items-center position-relative">
                                            <input id="password" :type="show ? 'text' : 'password'"
                                                wire:model.defer="password"
                                                class="form-control form-control-sm pr-5" />
                                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'" @click="show = !show"
                                                class="position-absolute eye-icon">
                                            </i>
                                        </div>
                                        @error('password')
                                            <span class="text-danger fst-italic">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="password_confirmation">Confirm New
                                            Password</label>
                                        <div x-data="{ show: false }"
                                            class="d-flex align-items-center position-relative">
                                            <input id="password_confirmation" :type="show ? 'text' : 'password'"
                                                wire:model.defer="password_confirmation"
                                                class="form-control form-control-sm pr-5" />
                                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'" @click="show = !show"
                                                class="position-absolute translate-middle-y eye-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-outline-light mt-3">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
