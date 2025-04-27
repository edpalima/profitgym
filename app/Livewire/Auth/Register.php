<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Register extends Component
{
    public string $first_name = '';
    public ?string $middle_name = null;
    public string $last_name = '';
    public ?string $address = null;
    public ?string $phone_number = null;
    public ?string $birth_date = null;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'MEMBER';
    
    // New properties for height and weight
    public ?float $height = null;
    public ?float $weight = null;

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone_number' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]/', // at least one digit
                'regex:/[@$!%*?&#]/', // at least one special character
            ],
            'role' => ['required', Rule::in(['ADMIN', 'MEMBER', 'STAFF'])],
            
            // Validation rules for height and weight
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ];
    }

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

    public function register()
    {
        $validated = $this->validate();

        // Optionally construct a full name
        $fullName = $this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name;

        // Create the user
        User::create([
            'name' => $fullName,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => User::ROLE_MEMBER,
            
            // Save height and weight to the database
            'height' => $this->height,
            'weight' => $this->weight,
        ]);

        session()->flash('success', 'Account registered successfully!');
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
