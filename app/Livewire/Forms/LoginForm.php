<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $check_field = 'email';
        $userNameData = User::where('username', $this->email)->exists();
        $emailData = User::where('email', $this->email)->exists();
        if (! $userNameData && !$emailData) {
            throw ValidationException::withMessages([
                'form.email' => ['The provided email or username is incorrect'],
            ]);
        } else if ( $userNameData) {
            $check_field = 'username';
        }
        $this->ensureIsNotRateLimited();

       $authentication = Auth::attempt([$check_field => $this->email, 'password' => $this->password]);
        if (!$authentication){
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.password' => [
                    'The password you entered is incorrect.',
                ],
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
