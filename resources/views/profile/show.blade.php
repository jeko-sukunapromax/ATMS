<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

            <div class="relative z-10 flex items-center justify-center text-center">
                <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                    {{ __('Profile') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto pt-0 pb-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
