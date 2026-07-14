<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

new #[Layout('layouts.guest')] #[Title('Login - POS')] class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public function authenticate()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return $this->redirect('/dashboard', navigate: true);
            }

            return $this->redirect('/pos', navigate: true);
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
};
?>

<div class="grid min-h-screen lg:grid-cols-2 bg-[#f9fafb]">

    <div class="flex flex-col justify-center px-4 py-12 sm:px-6 lg:px-20 xl:px-24">
        <div class="w-full max-w-sm mx-auto">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-[#101828]">
                    Welcome Back
                </h2>
                <p class="mt-2 text-sm text-[#6a7282]">
                    Please sign in to your account to continue.
                </p>
            </div>

            <div class="mt-8">
                <form wire:submit="authenticate" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-[#364153]">
                            Email Address
                        </label>
                        <div class="mt-1">
                            <input id="email" wire:model="email" type="email" required autocomplete="email"
                                class="block w-full px-3 py-2 border border-[#d1d5dc] rounded-md shadow-sm appearance-none focus:outline-none focus:ring-[#4a5565] focus:border-[#4a5565] sm:text-sm">
                        </div>
                        @error('email')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-[#364153]">
                            Password
                        </label>
                        <div class="mt-1">
                            <input id="password" wire:model="password" type="password" required
                                autocomplete="current-password"
                                class="block w-full px-3 py-2 border border-[#d1d5dc] rounded-md shadow-sm appearance-none focus:outline-none focus:ring-[#4a5565] focus:border-[#4a5565] sm:text-sm">
                        </div>
                        @error('password')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-[#101828] border border-transparent rounded-md shadow-sm hover:bg-[#1e2939] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#364153] transition-colors duration-200">
                            <span wire:loading.remove>Log In</span>
                            <span wire:loading>Authenticating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden lg:flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-20 xl:px-24">

        <div class="relative w-full max-w-md p-8 overflow-hidden flex items-center justify-center lg:aspect-4/5">

            <img class="object-contain w-full h-full z-10" src="{{ asset('images/hero.svg') }}"
                alt="Store Point of Sale Interface">
        </div>

    </div>
</div>
