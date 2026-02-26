<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

            <div class="relative z-10 flex items-center justify-center text-center">
                <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                    {{ __('Add New User') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="pt-0 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-3xl p-8 border border-gray-50">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- User Details -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-4">User Information</h3>
                            
                            <div>
                                <x-label for="name" value="{{ __('Full Name') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                <x-input id="name" name="name" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" value="{{ old('name') }}" required autofocus placeholder="E.g., Juan dela Cruz" />
                                <x-input-error for="name" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="email" value="{{ __('Email Address') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                <x-input id="email" name="email" type="email" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" value="{{ old('email') }}" required placeholder="juan@domain.com" />
                                <x-input-error for="email" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label for="position" value="{{ __('Position (Optional)') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                    <x-input id="position" name="position" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" value="{{ old('position') }}" placeholder="E.g., Manager" />
                                    <x-input-error for="position" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="office" value="{{ __('Office (Optional)') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                    <x-input id="office" name="office" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" value="{{ old('office') }}" placeholder="E.g., HR Dept" />
                                    <x-input-error for="office" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Password & Access Control -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-4">Security & Access</h3>

                            <div>
                                <x-label for="password" value="{{ __('Password') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                <x-input id="password" name="password" type="password" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" required />
                                <x-input-error for="password" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                <x-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" required />
                            </div>

                            <div>
                                <x-label for="role" value="{{ __('System Role') }}" class="text-xs font-black uppercase tracking-widest text-gray-700 mb-1 ml-1" />
                                <select id="role" name="role" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer font-bold text-gray-700" required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-widest ml-1">Assigning a role determines what this user can access.</p>
                                <x-input-error for="role" class="mt-2" />
                            </div>

                            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 mt-8">
                                <h4 class="text-xs font-black text-blue-800 uppercase tracking-widest mb-2">Note</h4>
                                <p class="text-xs font-medium text-blue-600 leading-relaxed">
                                    Ideally, users should be synced automatically from the iHRI system. Creating a user manually here bypasses the ATMS synchronization.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4 border-t border-gray-100 pt-8">
                        <a href="{{ route('users.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition">Cancel</a>
                        <x-button class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-white font-black text-xs tracking-widest shadow-xl shadow-indigo-200 transform hover:-translate-y-1 transition-all border-none">
                            {{ __('CREATE USER') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
