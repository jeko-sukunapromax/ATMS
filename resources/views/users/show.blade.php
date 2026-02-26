<x-app-layout>
    @php
        $roleLabel = $user->getRoleNames()->first() ?: 'User';
        $roleColor = match(strtolower($roleLabel)) {
            'superadmin' => 'purple',
            'admin'      => 'indigo',
            'auditor'    => 'orange',
            default      => 'gray'
        };
    @endphp

    {{-- Page Header --}}
    <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden mb-8">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-indigo-200 text-xs font-black uppercase tracking-widest mb-1">User Profile</p>
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-none">
                    {{ $user->name }}
                </h1>
            </div>
            <a href="{{ route('users.index') }}"
               class="group relative inline-flex items-center justify-center px-7 py-3.5 text-sm font-black tracking-[0.12em] text-indigo-900 bg-white rounded-2xl overflow-hidden transition-all hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] uppercase">
                <span class="relative flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back
                </span>
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 shadow-2xl shadow-gray-100/50 border border-gray-100">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Profile Details --}}
            <div class="flex flex-col items-center text-center gap-5">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $user->name }}</h2>
                    <p class="text-sm font-bold text-gray-400 mt-1">{{ $user->email }}</p>
                </div>

                <span class="px-5 py-2.5 bg-{{ $roleColor }}-50 text-{{ $roleColor }}-600 rounded-xl text-xs font-black uppercase tracking-widest inline-flex items-center gap-2 border border-{{ $roleColor }}-100">
                    <span class="w-2 h-2 rounded-full bg-{{ $roleColor }}-500 animate-pulse"></span>
                    {{ ucfirst($roleLabel) }}
                </span>

                {{-- Action Buttons --}}
                <div class="flex gap-3 mt-2 w-full">
                    <a href="{{ route('users.edit', $user) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Edit Role
                    </a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Remove this user from the local directory?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-red-50 text-red-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-200 transition-all transform hover:-translate-y-0.5"
                                title="Remove User">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Remove
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right: Details --}}
            <div class="lg:col-span-2 space-y-6">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest pb-3 border-b border-gray-100">
                    User Information
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Full Name --}}
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Full Name</p>
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-gray-700 font-bold text-sm">
                            {{ $user->name }}
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Email Address</p>
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-gray-700 font-bold text-sm break-all">
                            {{ $user->email }}
                        </div>
                    </div>

                    {{-- Position --}}
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Position / Designation</p>
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-gray-700 font-bold text-sm">
                            {{ $user->position ?: '—' }}
                        </div>
                    </div>

                    {{-- Office --}}
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Office / Department</p>
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-gray-700 font-bold text-sm">
                            {{ $user->office ?: '—' }}
                        </div>
                    </div>

                    {{-- System Role --}}
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">System Role</p>
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 font-bold text-sm">
                            <span class="text-{{ $roleColor }}-600">{{ ucfirst($roleLabel) }}</span>
                        </div>
                    </div>

                    {{-- iHRI UUID --}}
                    @if($user->ihri_uuid)
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">iHRI UUID</p>
                        <div class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 text-gray-500 font-mono text-xs break-all">
                            {{ $user->ihri_uuid }}
                        </div>
                    </div>
                    @endif
                </div>

                {{-- iHRI Note --}}
                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 mt-4">
                    <h4 class="text-xs font-black text-blue-800 uppercase tracking-widest mb-2">Note</h4>
                    <p class="text-xs font-medium text-blue-600 leading-relaxed">
                        User details are synchronized from the iHRI system and cannot be edited locally.
                        You may manage this user's access level by clicking <strong>Edit Role</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
