<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use SweetAlert2\Laravel\Traits\WithSweetAlert;

#[Layout('components.layouts.auth', ['title' => 'Login'])]
class Login extends Component
{
    use WithSweetAlert;

    #[Validate('required|email')]
    public $email = '';
    #[Validate('required|string')]
    public $password = '';
    #[Validate('boolean')]
    public $remember = false;

    public function login()
    {
        $this->validate();

        try {
            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ], $this->remember)) {
                session()->regenerate();
                // $this->swalSuccess([
                //     'title' => 'Login Successful',
                //     'text' => 'Welcome back!',
                // ]);
                return redirect()->intended('/my-tasks');
            } else {
                $this->swalError([
                    'title' => 'Login Failed',
                    'text' => 'Invalid email or password.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            $this->swalError([
                'title' => 'Login Failed',
                'text' => 'An error occurred during login. Please try again.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
