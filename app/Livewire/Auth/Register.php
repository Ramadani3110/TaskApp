<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('components.layouts.auth', ['title' => 'Register'])]
class Register extends Component
{
    use WithSweetAlert;

    #[Validate(['required', 'string', 'max:50'])]
    public $name = '';
    #[Validate([
        'required',
        'email',
        'unique:users,email'
    ])]
    public $email = '';
    #[Validate([
        'required',
        'string',
        'min:8',
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
    ])]
    public $password = '';
    public $passwordStrength = 'weak';

    public function messages()
    {
        return [
            'password.regex' => 'Password must combine uppercase, lowercase, numbers, and special characters.'
        ];
    }

    public function updatedPassword($value)
    {
        $this->passwordStrength = $this->checkPasswordStrength($value);
    }

    private function checkPasswordStrength($password)
    {
        $score = 0;

        if (preg_match('/[a-z]/', $password)) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/\d/', $password)) $score++;
        if (preg_match('/[\W_]/', $password)) $score++;
        if (strlen($password) >= 8) $score++;

        return match (true) {
            $score <= 2 => 'weak',
            $score === 3 => 'medium',
            default => 'strong',
        };
    }

    public function register()
    {
        $this->validate();
        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $this->swalSuccess([
                'title' => 'Registration Successful',
                'text' => 'You can now log in with your credentials.',
            ]);
            $this->reset(['name', 'email', 'password']);
            return redirect()->route('/');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            $this->swalError([
                'title' => 'Registration Failed',
                'text' => 'An error occurred during registration. Please try again.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
