<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-tr from-slate-50 via-white to-blue-50">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl shadow-blue-100/50 sm:rounded-3xl border border-blue-50">
            
            <div class="mb-10">
                <x-authentication-card-logo />
            </div>

            <div class="mb-8 text-center">
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Welcome Back</h2>
                <p class="text-gray-400 font-medium mt-1">Audit Tracking & Management System</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="relative">
                    <x-label for="email" value="{{ __('Email or Username') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                    <x-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl focus:ring-blue-500 focus:border-blue-500 p-4 transition-all duration-300" type="text" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email or username" />
                </div>

                <div class="mt-6 relative">
                    <x-label for="password" value="{{ __('Password') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                    <x-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-100 rounded-2xl focus:ring-blue-500 focus:border-blue-500 p-4 transition-all duration-300" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="rounded-md border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                        <span class="ms-2 text-sm font-bold text-gray-500">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-bold text-blue-600 hover:text-blue-800 transition" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-10">
                    <x-button class="w-full justify-center py-4 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 rounded-2xl text-white font-black text-sm tracking-widest shadow-xl shadow-blue-200 transform hover:-translate-y-1 transition-all duration-300 border-none">
                        {{ __('SIGN IN TO SYSTEM') }}
                    </x-button>
                </div>
            </form>

            <div class="mt-10 pt-8 border-t border-gray-50 text-center">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-widest">
                    Security Policy: iHRI Integrated Authentication
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
