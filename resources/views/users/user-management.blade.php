<x-app-layout>
    <!-- Page Header (Premium Gradient) -->
    <div class="relative bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 rounded-[2.5rem] overflow-hidden mb-8 shadow-2xl shadow-indigo-900/20">
        <!-- Decorative blobs -->
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-indigo-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob"></div>
        <div class="absolute inset-0 bg-[#000] bg-opacity-20 backdrop-blur-[2px]"></div>
        
        <div class="relative z-10 px-10 py-12 sm:px-16 sm:py-16 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0">
                <h2 class="text-xs font-black text-indigo-300 uppercase tracking-[0.2em] mb-2">Directory</h2>
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    User Management
                </h1>
                <p class="mt-3 text-sm font-medium text-indigo-100/80 max-w-md leading-relaxed">
                    Manage system access, assign roles, and review the directory of all synced internal employees and users.
                </p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 flex flex-col items-center justify-center shadow-xl min-w-[140px]">
                <h3 class="text-4xl font-black text-white tracking-tighter text-center">{{ count($permanentUsers) }}</h3>
                <p class="text-[10px] font-black text-indigo-200 mt-2 uppercase tracking-widest text-center">Total Records</p>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 shadow-2xl shadow-gray-100/50 border border-gray-100">
        
        <!-- Alerts -->
        @if(session('warning'))
            <div class="mb-8 p-6 bg-orange-50/80 backdrop-blur-sm border border-orange-100 text-orange-700 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-2 bg-orange-200/50 rounded-xl shrink-0"><svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                <div>
                    <p class="font-black uppercase tracking-widest text-[10px] mb-1">Action Required</p>
                    <p class="text-sm font-bold">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-50/80 backdrop-blur-sm border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-2 bg-emerald-200/50 rounded-xl shrink-0"><svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                <div>
                    <p class="font-black uppercase tracking-widest text-[10px] mb-1">Success</p>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Floating Filters Bar -->
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col xl:flex-row gap-4 mb-10 items-center justify-between bg-gray-50/50 p-4 rounded-3xl border border-gray-100 shadow-sm relative z-20">
            <div class="relative w-full xl:w-1/3 group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border border-transparent rounded-2xl text-sm font-bold text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400 group-hover:border-gray-200">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full xl:w-auto flex-1 justify-end">
                <select name="position" onchange="this.form.submit()" class="w-full sm:w-56 px-4 py-4 bg-white border border-transparent rounded-2xl text-xs font-bold text-gray-600 shadow-sm focus:ring-2 focus:ring-indigo-500 hover:border-gray-200 transition-all cursor-pointer truncate">
                    <option value="">All Positions</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($pos, 25) }}</option>
                    @endforeach
                </select>

                <select name="office" onchange="this.form.submit()" class="w-full sm:w-64 px-4 py-4 bg-white border border-transparent rounded-2xl text-xs font-bold text-gray-600 shadow-sm focus:ring-2 focus:ring-indigo-500 hover:border-gray-200 transition-all cursor-pointer truncate">
                    <option value="">All Offices</option>
                    @foreach($offices as $off)
                        <option value="{{ $off }}" {{ request('office') == $off ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($off, 30) }}</option>
                    @endforeach
                </select>
                
                @if(request()->anyFilled(['search', 'position', 'office']))
                    <a href="{{ route('users.index') }}" class="flex items-center justify-center px-6 py-4 bg-red-50 text-red-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors whitespace-nowrap">
                        Clear
                    </a>
                @endif
            </div>
        </form>

        <!-- Modern User Card List -->
        <div class="space-y-4">
            @forelse($permanentUsers as $user)
                @php
                    $roleLabel = $user->getRoleNames()->first() ?: 'User';
                    $roleColor = match(strtolower($roleLabel)) {
                        'superadmin' => 'purple',
                        'admin' => 'indigo',
                        'auditor' => 'orange',
                        default => 'gray'
                    };
                @endphp
                <div class="group bg-white border border-gray-100 rounded-[2rem] p-5 lg:p-6 hover:shadow-2xl hover:shadow-indigo-100/40 hover:border-indigo-100 transition-all duration-300 flex flex-col lg:flex-row items-start lg:items-center gap-6 relative overflow-hidden">
                    
                    <!-- Decorative hover gradient -->
                    <div class="absolute inset-y-0 left-0 w-1 bg-{{ $roleColor }}-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <!-- Avatar and Details -->
                    <div class="flex items-center gap-5 lg:w-1/3">
                        <div class="relative shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=4F46E5&background=EEF2FF&rounded=true&bold=true&size=128" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl shadow-sm group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-500 object-cover border-2 border-white">
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 border-[3px] border-white rounded-full"></div>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900 uppercase tracking-tight">{{ $user->name }}</h3>
                            <p class="text-[11px] font-bold text-gray-500 mt-1">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Role & Position -->
                    <div class="lg:w-1/4 flex flex-col gap-3">
                        <div>
                            <span class="px-4 py-1.5 bg-{{ $roleColor }}-50 text-{{ $roleColor }}-600 rounded-xl text-[10px] font-black uppercase tracking-widest inline-flex items-center gap-2 border border-{{ $roleColor }}-100 group-hover:bg-{{ $roleColor }}-100 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $roleColor }}-500 animate-pulse"></span>
                                {{ ucfirst($roleLabel) }}
                            </span>
                        </div>
                        <p class="text-xs font-bold text-gray-600 line-clamp-2 leading-relaxed group-hover:text-gray-900 transition-colors" title="{{ $user->position ?: 'No Position Defined' }}">
                            {{ $user->position ?: 'No Position Defined' }}
                        </p>
                    </div>

                    <!-- Office -->
                    <div class="lg:w-1/4">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Office / Dept</p>
                        </div>
                        <p class="text-sm font-bold text-gray-700 line-clamp-2 leading-tight">
                            {{ $user->office ?: 'N/A' }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="lg:w-auto lg:ml-auto flex items-center gap-2 mt-4 lg:mt-0">
                        <a href="{{ route('users.edit', $user) }}" class="p-4 bg-gray-50 text-gray-500 rounded-2xl hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300 transform group-hover:scale-105" title="Edit Access Control">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Remove user from local directory?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-4 bg-gray-50 text-gray-400 rounded-2xl hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-200 transition-all duration-300 transform group-hover:scale-105" title="Remove User">
                                <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-gray-50/50 rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    @if(request()->anyFilled(['search', 'position', 'office']))
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">No Results Found</h3>
                        <p class="text-gray-400 text-sm font-medium mt-2">Adjust your search or filters to see more people.</p>
                        <a href="{{ route('users.index') }}" class="mt-6 inline-block text-indigo-600 font-bold hover:underline">Clear Filters &rarr;</a>
                    @else
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Directory Empty</h3>
                        <p class="text-gray-400 text-sm font-medium mt-2">Initial sync might be in progress over the iHRI API.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <div class="mt-10 flex justify-center w-full">
            {{ $permanentUsers->links() }}
        </div>
    </div>
</x-app-layout>
