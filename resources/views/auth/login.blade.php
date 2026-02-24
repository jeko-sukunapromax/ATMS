<x-guest-layout>
    <!-- Background Image and Overlays -->
    <div class="fixed inset-0 z-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=2070&auto=format&fit=crop');">
        <!-- Colored overlay for the maroon/reddish tint -->
        <div class="absolute inset-0 bg-gradient-to-tr from-[#6b2c2c]/95 to-[#8A3B3B]/80 mix-blend-multiply"></div>
        <!-- Blur effect -->
        <div class="absolute inset-0 backdrop-blur-[6px]"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="w-full max-w-6xl flex flex-col lg:flex-row items-center justify-center gap-12 lg:gap-24">
            
            <!-- Left Side Logo -->
            <div class="hidden lg:flex w-full lg:w-1/2 justify-end pr-4">
                <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="Bayambang Seal" class="w-80 h-auto drop-shadow-[0_0_30px_rgba(0,0,0,0.5)]">
            </div>

            <!-- Right Side Form & Titles -->
            <div class="w-full lg:w-3/5 max-w-[800px]">
                
                <!-- Titles -->
                <div class="flex flex-col items-center text-center justify-center mb-8">
                    <!-- Mobile logo -->
                    <div class="lg:hidden flex justify-center mb-8">
                        <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="Bayambang Seal" class="w-48 drop-shadow-2xl">
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl font-medium text-white tracking-[0.1em] uppercase mb-1 drop-shadow-sm">
                        Audit Tracking
                    </h1>
                    <h2 class="text-3xl sm:text-4xl font-medium text-[#FFD700] tracking-[0.1em] uppercase drop-shadow-sm">
                        Management System
                    </h2>
                </div>

                <!-- Glassmorphism Form container -->
                <div class="w-full bg-white/10 backdrop-blur-xl border border-white/20 rounded-[3rem] px-14 py-12 sm:px-20 sm:py-16 shadow-[0_8px_40px_0_rgba(0,0,0,0.5)]">
                    
                    <x-validation-errors class="mb-4 p-4 bg-red-500/20 text-red-100 rounded-xl border border-red-500/30" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-400 bg-green-500/20 p-4 rounded-xl border border-green-500/30">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-white text-sm font-semibold mb-2 ml-1">Email</label>
                            <input id="email" type="text" name="email" :value="old('email')" required autofocus autocomplete="username" 
                                class="w-full bg-white/20 border-white/20 focus:bg-white/30 focus:border-white/50 focus:ring-1 focus:ring-white rounded-xl px-5 py-4 text-white placeholder-white/70 transition-all outline-none backdrop-blur-sm" 
                                placeholder="your@email.com">
                        </div>

                        <div x-data="{ showPassword: false }" class="relative">
                            <label for="password" class="block text-white text-sm font-semibold mb-2 ml-1">Password</label>
                            <input id="password" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" 
                                class="w-full bg-white/20 border-white/20 focus:bg-white/30 focus:border-white/50 focus:ring-1 focus:ring-white rounded-xl px-5 py-4 pr-12 text-white placeholder-white/70 transition-all outline-none backdrop-blur-sm" 
                                placeholder="••••••••">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pt-7">
                                <button type="button" @click="showPassword = !showPassword" class="text-white/60 hover:text-white focus:outline-none transition-colors">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <svg x-show="showPassword" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center pt-2 ml-1">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-white/40 bg-white/20 text-[#FFD700] focus:ring-[#FFD700] focus:ring-offset-0 focus:ring-offset-transparent outline-none">
                            <label for="remember_me" class="ml-3 text-sm text-white font-medium cursor-pointer">Remember me</label>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-transparent">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-white hover:text-white underline underline-offset-4 decoration-white/50 transition-colors ml-1" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @else
                                <span></span>
                            @endif

                            <button type="submit" class="bg-[#FFD700] hover:bg-[#E6C200] text-gray-900 px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-sm transition-transform hover:scale-105 shadow-[0_4px_15px_rgba(255,215,0,0.3)] border-none">
                                LOG IN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
