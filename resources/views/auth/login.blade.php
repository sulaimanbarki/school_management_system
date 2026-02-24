<x-guest-layout>
    <div class="w-full sm:max-w-md mt-6 px-10 py-12 glass-card overflow-hidden">
        <div class="flex flex-col items-center mb-10">
            <div class="p-3 bg-blue-600 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-school text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Welcome Back!</h2>
            <p class="text-gray-500 mt-2 text-sm">Please sign in to your account</p>
        </div>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ isset($guard) ? url($guard.'/login') :  route('login') }}">
            @csrf
                
            <div class="mb-6">
                <x-jet-label for="email" value="{{ __('Email Address') }}" class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2" />
                <div class="input-icon-wrapper">
                    <x-jet-input id="email" class="block w-full input-with-icon" type="email" name="email" :value="old('email')" required autofocus placeholder="name@school.com" />
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <x-jet-label for="password" value="{{ __('Password') }}" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
                    @if (Route::has('password.request'))
                        {{-- <a class="text-xs font-medium text-blue-600 hover:text-blue-500 transition-colors" href="{{ route('password.request') }}">
                            {{ __('Forgot?') }}
                        </a> --}}
                    @endif
                </div>
                <div class="input-icon-wrapper">
                    <x-jet-input id="password" class="block w-full input-with-icon" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8">
                <label for="remember_me" class="flex items-center cursor-pointer group">
                    <x-jet-checkbox id="remember_me" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all cursor-pointer" />
                    <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">{{ __('Keep me logged in') }}</span>
                </label>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl transform transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ __('Sign In') }}
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 text-center text-white text-sm drop-shadow-md">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'School Management System') }}. All rights reserved.</p>
    </div>
</x-guest-layout>