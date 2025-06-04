<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactSection extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|min:10',
    ];

    public function submit()
    {
        $this->validate();

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        session()->flash('success-message', 'Your message has been sent successfully!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-section');
    }
}
