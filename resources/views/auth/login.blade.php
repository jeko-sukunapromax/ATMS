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
                <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="Bayambang Seal" class="w-80 h-auto drop-shadow-[0_0_30px_rgba(0,0,0,0.5)] transform hover:scale-105 transition duration-500">
            </div>

            <!-- Right Side Form & Titles -->
            <div class="w-full lg:w-1/2 max-w-[450px]">
                
                <!-- Title Top Right -->
                <div class="text-center lg:text-right mb-8">
                    <!-- Mobile logo -->
                    <div class="lg:hidden flex justify-center mb-8">
                        <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="Bayambang Seal" class="w-48 drop-shadow-2xl">
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl font-medium text-white tracking-[0.1em] uppercase mb-1">
                        Audit Tracking
                    </h1>
                    <h2 class="text-3xl sm:text-4xl font-medium text-[#FFD700] tracking-[0.1em] uppercase">
                        Management System
                    </h2>
                </div>

                <!-- Glassmorphism Form container -->
                <div class="w-full bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2.5rem] p-8 sm:p-10 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]">
                    
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

                        <div>
                            <label for="password" class="block text-white text-sm font-semibold mb-2 ml-1">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password" 
                                class="w-full bg-white/20 border-white/20 focus:bg-white/30 focus:border-white/50 focus:ring-1 focus:ring-white rounded-xl px-5 py-4 text-white placeholder-white/70 transition-all outline-none backdrop-blur-sm" 
                                placeholder="••••••••">
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
