<x-app-layout>
    @php
        $officeName = count($employees) > 0 ? ($employees[0]['office_name'] ?? 'Department') : 'Department Directory';
    @endphp
    <!-- Page Header (Premium Gradient) -->
    <div class="relative bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 rounded-[2.5rem] overflow-hidden mb-8 shadow-2xl shadow-indigo-900/20">
        <!-- Decorative blobs -->
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-indigo-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob"></div>
        <div class="absolute inset-0 bg-[#000] bg-opacity-20 backdrop-blur-[2px]"></div>
        
        <div class="relative z-10 px-10 py-12 sm:px-16 sm:py-16 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0">
                <div class="flex items-center gap-4 mb-3">
                    <a href="{{ route('offices.index') }}" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white backdrop-blur-md transition-colors border border-white/20" title="Back to Directory">
                        <svg class="w-4 h-4 pr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <h2 class="text-xs font-black text-indigo-300 uppercase tracking-[0.2em]">Office Roster</h2>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    {{ $officeName }}
                </h1>
                <p class="mt-3 text-sm font-medium text-indigo-100/80 max-w-md leading-relaxed">
                    View the full employee roster and organizational details for this specific office.
                </p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 flex flex-col items-center justify-center shadow-xl min-w-[140px]">
                <h3 class="text-4xl font-black text-white tracking-tighter text-center">{{ count($employees) }}</h3>
                <p class="text-[10px] font-black text-indigo-200 mt-2 uppercase tracking-widest text-center">Total Staff</p>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 shadow-2xl shadow-gray-100/50 border border-gray-100">
        
        <!-- Search and Filter Bar -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Registered Employees</h3>
                <p class="text-sm text-gray-500 mt-1">Found {{ count($employees) }} staff members</p>
            </div>
            
            <form method="GET" action="{{ route('offices.show', $uuid) }}" class="relative w-full md:w-1/2 lg:w-1/3">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or position..." class="block w-full pl-11 pr-10 py-3 border border-gray-200 rounded-2xl leading-5 bg-gray-50/50 hover:bg-gray-50 focus:bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm transition-all duration-300">
                @if(request()->filled('search'))
                    <a href="{{ route('offices.show', $uuid) }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </form>
        </div>

        <!-- Modern User Card List -->
        <div class="space-y-4">
            @forelse($employees as $employee)
                @php
                    $appointment = $employee['appointment_type'] ?? 'Employee';
                    $roleColor = match(strtolower($appointment)) {
                        'permanent' => 'indigo',
                        'job order' => 'orange',
                        'casual' => 'emerald',
                        default => 'gray'
                    };
                    
                    // Form name fallback
                    $nameParts = [];
                    if (!empty($employee['first_name'])) $nameParts[] = $employee['first_name'];
                    if (!empty($employee['last_name'])) $nameParts[] = $employee['last_name'];
                    $firstNameLastName = implode(' ', $nameParts);
                    $name = !empty($employee['name']) ? $employee['name'] : ($firstNameLastName ?: 'Unknown User');
                    
                    $position = $employee['position_name'] ?? $employee['position'] ?? 'No Position Defined';
                @endphp
                <div class="group bg-white border border-gray-100 rounded-[2rem] p-5 lg:p-6 hover:shadow-2xl hover:shadow-indigo-100/40 hover:border-indigo-100 transition-all duration-300 flex flex-col lg:flex-row items-start lg:items-center gap-6 relative overflow-hidden">
                    
                    <!-- Decorative hover gradient -->
                    <div class="absolute inset-y-0 left-0 w-1 bg-{{ $roleColor }}-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <!-- Avatar and Details -->
                    <div class="flex items-center gap-5 lg:w-1/3">
                        <div class="relative shrink-0">
                            @if(isset($employee['profile_photo_url']) && str_starts_with($employee['profile_photo_url'], 'http'))
                                <img src="{{ $employee['profile_photo_url'] }}" alt="{{ $name }}" class="w-16 h-16 rounded-2xl shadow-sm group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-500 object-cover border-2 border-white">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&color=4F46E5&background=EEF2FF&rounded=true&bold=true&size=128" alt="{{ $name }}" class="w-16 h-16 rounded-2xl shadow-sm group-hover:scale-105 group-hover:-rotate-3 transition-transform duration-500 object-cover border-2 border-white">
                            @endif
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 border-[3px] border-white rounded-full"></div>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-gray-900 uppercase tracking-tight">{{ $name }}</h3>
                            <p class="text-[11px] font-bold text-gray-500 mt-1">{{ $employee['email'] ?? 'No Email Provided' }}</p>
                        </div>
                    </div>

                    <!-- Role & Position -->
                    <div class="lg:w-1/3 flex flex-col gap-3">
                        <div>
                            <span class="px-4 py-1.5 bg-{{ $roleColor }}-50 text-{{ $roleColor }}-600 rounded-xl text-[10px] font-black uppercase tracking-widest inline-flex items-center gap-2 border border-{{ $roleColor }}-100 group-hover:bg-{{ $roleColor }}-100 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $roleColor }}-500 animate-pulse"></span>
                                {{ $appointment }}
                            </span>
                        </div>
                        <p class="text-xs font-bold text-gray-600 line-clamp-2 leading-relaxed group-hover:text-gray-900 transition-colors" title="{{ $position }}">
                            {{ $position }}
                        </p>
                    </div>

                    <!-- Office -->
                    <div class="lg:w-1/3">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Department</p>
                        </div>
                        <p class="text-sm font-bold text-gray-700 line-clamp-2 leading-tight">
                            {{ $employee['office_name'] ?? $officeName }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-gray-50/50 rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">No Employees Found</h3>
                    <p class="text-gray-400 text-sm font-medium mt-2">There are currently no employees assigned to this office.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
