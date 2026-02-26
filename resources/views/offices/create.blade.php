<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

            <div class="relative z-10 flex items-center justify-center text-center">
                <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                    {{ __('Add New Office') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="pt-0 pb-12 mt-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-3xl p-8 border border-gray-50">
                <form action="{{ route('offices.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter mb-4">Office Details</h3>
                        
                        <div>
                            <x-label for="name" value="{{ __('Office Name') }}" class="text-sm font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                            <x-input id="name" name="name" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" value="{{ old('name') }}" required autofocus placeholder="E.g., Information Technology Department" />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="acronym" value="{{ __('Acronym (Optional)') }}" class="text-sm font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                            <x-input id="acronym" name="acronym" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" value="{{ old('acronym') }}" placeholder="E.g., ITD" />
                            <x-input-error for="acronym" class="mt-2" />
                        </div>

                        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 mt-8">
                            <h4 class="text-sm font-black text-blue-800 uppercase tracking-widest mb-2">Note</h4>
                            <p class="text-sm font-medium text-blue-600 leading-relaxed">
                                Manually added offices are marked as "Local" and will not sync employees from iHRIS. They are primarily used for managing audit projects inside ATMS when an office is not yet in the main directory.
                            </p>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4 border-t border-gray-100 pt-8">
                        <a href="{{ route('offices.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-200 transition">Cancel</a>
                        <x-button class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-white font-black text-sm tracking-widest shadow-xl shadow-indigo-200 transform hover:-translate-y-1 transition-all border-none">
                            {{ __('CREATE OFFICE') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
