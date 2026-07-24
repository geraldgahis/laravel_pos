<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

new #[Layout('layouts.guest')] #[Title('Create Account — TindaHub')] class extends Component {
    public string $name = '';
    public string $store_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'store_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'merchant',
        ]);

        Store::create([
            'owner_id' => $user->id,
            'name' => $this->store_name,
            'is_active' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return $this->redirect('/dashboard', navigate: true);
    }
};
?>

<!-- Wrapper perfectly centers the card in the remaining viewport space -->
<div class="flex-1 flex items-center justify-center p-4 w-full my-8">

    <!-- Register Card using your custom shadow and max-w-sm size -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-indigo-900/5 border border-indigo-50 p-6 sm:p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <div
                class="inline-flex items-center justify-center w-12 h-12 bg-linear-to-br from-indigo-600 to-indigo-800 text-white rounded-xl mb-4 shadow-sm">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                    <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4" />
                    <path d="M2 7h20" />
                    <path
                        d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7" />
                </svg>
            </div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Join Tinda<span
                    class="text-indigo-600">Hub</span></h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Create your merchant account to get started</p>
        </div>

        <!-- Form -->
        <form wire:submit="register" class="space-y-4">

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                    placeholder="Juan Dela Cruz"
                    class="w-full px-3 py-2 text-sm rounded-lg border bg-gray-50 text-gray-900 outline-none transition-all duration-200 placeholder:text-gray-400
                    @error('name') border-red-500 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror">
                @error('name')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Store Name -->
            <div>
                <label for="store_name" class="block text-sm font-bold text-gray-700 mb-1">Store Name</label>
                <input wire:model="store_name" id="store_name" type="text" required placeholder="Aling Nena's Store"
                    class="w-full px-3 py-2 text-sm rounded-lg border bg-gray-50 text-gray-900 outline-none transition-all duration-200 placeholder:text-gray-400
                    @error('store_name') border-red-500 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror">
                @error('store_name')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                <input wire:model="email" id="email" type="email" required autocomplete="username"
                    placeholder="merchant@tindahub.ph"
                    class="w-full px-3 py-2 text-sm rounded-lg border bg-gray-50 text-gray-900 outline-none transition-all duration-200 placeholder:text-gray-400
                    @error('email') border-red-500 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror">
                @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-3 py-2 text-sm rounded-lg border bg-gray-50 text-gray-900 outline-none transition-all duration-200 placeholder:text-gray-400
                    @error('password') border-red-500 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror">
                @error('password')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Confirm
                    Password</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                    autocomplete="new-password" placeholder="••••••••"
                    class="w-full px-3 py-2 text-sm rounded-lg border bg-gray-50 text-gray-900 outline-none transition-all duration-200 placeholder:text-gray-400 border-gray-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-2.5 mt-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-btn-indigo hover:shadow-hover-indigo hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500">

                <span wire:loading.remove>Create Account</span>

                <!-- Loading State -->
                <span wire:loading.inline-flex class="items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white shrink-0" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Setting up...</span>
                </span>
            </button>
        </form>

        <!-- Footer Link -->
        <div class="mt-6 text-center text-sm text-gray-500 pt-5 border-t border-gray-100">
            <span>Already have an account?</span>
            <a href="/login" wire:navigate
                class="text-indigo-600 font-bold hover:text-indigo-700 hover:underline ml-1 transition-colors">
                Sign in
            </a>
        </div>
    </div>
</div>
