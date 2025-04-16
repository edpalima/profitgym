<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Register extends Component
{
    public string $name = '';
    public string $first_name = '';
    public ?string $middle_name = null;
    public string $last_name = '';
    public ?string $address = null;
    public ?string $phone_number = null;
    public ?string $birth_date = null;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'member';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => ['required', Rule::in(['admin', 'member', 'staff'])],
        ];
    }

    public function register()
    {
        $validated = $this->validate();

        User::create([
            'name' => $this->name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        session()->flash('success', 'Account registered successfully!');
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
