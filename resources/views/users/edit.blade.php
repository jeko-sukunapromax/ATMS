<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight uppercase">
            {{ __('Edit User Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-3xl p-8 border border-gray-50">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- User Details (Read Only) -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-4">User Information</h3>
                            
                            <div>
                                <x-label for="name" value="{{ __('Full Name') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <x-input id="name" type="text" class="block w-full bg-gray-100 border-gray-100 rounded-2xl p-4 text-gray-500 cursor-not-allowed" :value="$user->name" disabled />
                            </div>

                            <div>
                                <x-label for="email" value="{{ __('Email Address') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <x-input id="email" type="email" class="block w-full bg-gray-100 border-gray-100 rounded-2xl p-4 text-gray-500 cursor-not-allowed" :value="$user->email" disabled />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label for="position" value="{{ __('Position') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                    <x-input id="position" type="text" class="block w-full bg-gray-100 border-gray-100 rounded-2xl p-4 text-gray-500 cursor-not-allowed" :value="$user->position" disabled />
                                </div>
                                <div>
                                    <x-label for="office" value="{{ __('Office') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                    <x-input id="office" type="text" class="block w-full bg-gray-100 border-gray-100 rounded-2xl p-4 text-gray-500 cursor-not-allowed" :value="$user->office" disabled />
                                </div>
                            </div>
                        </div>

                        <!-- Role Management -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-4">Access Control</h3>

                            <div>
                                <x-label for="role" value="{{ __('System Role') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <select id="role" name="role" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer font-bold text-gray-700">
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
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
                                    User details are synchronized from the iHRI system and cannot be edited locally. 
                                    However, you can manage their access level within the Audit Tracking Management System by changing their role above.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4 border-t border-gray-100 pt-8">
                        <a href="{{ route('users.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition">Cancel</a>
                        <x-button class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-white font-black text-xs tracking-widest shadow-xl shadow-indigo-200 transform hover:-translate-y-1 transition-all border-none">
                            {{ __('UPDATE USER ROLE') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
