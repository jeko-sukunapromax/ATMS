<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

            <div class="relative z-10 flex items-center justify-center text-center">
                <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                    {{ __('API Tokens') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto pt-0 pb-10 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-app-layout>
