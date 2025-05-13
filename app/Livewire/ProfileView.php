<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class ProfileView extends Component
{
    use WithPagination, WithFileUploads;

    public $user;
    public $latestMembership;
    public $showModal = false;
    public $showEditModal = false;
    public $search = '';

    // Editable fields
    public $name;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $address;
    public $birth_date;
    public $weight;
    public $weight_unit;
    public $height;
    public $height_unit;
    public $photo;
    public $currentPhoto;
    public $photoPreview;
    public $password;
    public $password_confirmation;

    protected $paginationTheme = 'bootstrap';

    protected function messages()
    {
        return [
            'password.regex' => 'Password must include an uppercase letter, lowercase letter, number, and special character.',
            'password.regex:/[a-z]/' => 'Password must contain at least one lowercase letter.',
            'password.regex:/[A-Z]/' => 'Password must contain at least one uppercase letter.',
            'password.regex:/[0-9]/' => 'Password must contain at least one digit.',
            'password.regex:/[@$!%*?&#]/' => 'Password must contain at least one special character (e.g. @$!%*?&#).',
        ];
    }

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login'); // Make sure your login route is named 'login'
        }

        $this->user = auth()->user();
        $this->latestMembership = $this->user->latestMembership();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        $this->name = $this->user->fullName;
        $this->first_name = $this->user->first_name;
        $this->middle_name = $this->user->middle_name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->address = $this->user->address;
        $this->birth_date = $this->user->birth_date;
        $this->weight = $this->user->weight;
        $this->weight_unit = $this->user->weight_unit;
        $this->height = $this->user->height;
        $this->height_unit = $this->user->height_unit;
        $this->photoPreview = $this->user->getFilamentAvatarUrl();
    }

    public function showEditProfileModal()
    {
        $this->showEditModal = true;
    }

    public function updatedPhoto()
    {
        if ($this->photo) {
            $this->photoPreview = $this->photo->temporaryUrl();
        } else {
            $this->photoPreview = $this->user->getFilamentAvatarUrl();
        }
    }

    public function updateProfile()
    {
        $this->validate([
            // 'email' => 'required|email',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|string',
            'height' => 'nullable|numeric',
            'height_unit' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]/', // at least one digit
                'regex:/[@$!%*?&#]/', // at least one special character
            ],
        ]);

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('user-photos', 'public');
        }

        $updateData = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'birth_date' => $this->birth_date,
            'weight' => $this->weight,
            'height' => $this->height,
        ];

        if ($photoPath) {
            $updateData['photo'] = $photoPath;
        }

        if ($this->password) {
            $updateData['password'] = Hash::make($this->password);
        }

        $this->user->update($updateData);

        session()->flash('message', 'Profile updated successfully.');
        $this->showEditModal = false;
        $this->loadUserData(); // Refresh UI
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $memberships = $this->user->memberships()
            ->with('membership')
            ->whereHas('membership', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('start_date')
            ->paginate(5);

        return view('livewire.profile-view', compact('memberships'));
    }

    public function showMembershipModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
