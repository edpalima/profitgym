<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            $user = Auth::user();
            if (
                in_array($user->role, [User::ROLE_ADMIN, User::ROLE_STAFF])
            ) {
                // Redirect to the admin panel if the user is an admin
                return redirect()->route('filament.admin.pages.dashboard');  // Update the route name to your actual admin panel route
            }

            return redirect()->route('account');
        }

        $this->addError('email', 'The provided credentials are incorrect.');
    }

    public function render()
    {
        return view('livewire.auth.login'); // Adjust layout if needed
    }
}
