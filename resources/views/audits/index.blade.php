<x-app-layout>
    <!-- Page Header -->
    <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden mb-8">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

        <div class="relative z-10 flex items-center justify-between">
            <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                Audit Tracking
            </h2>
            <a href="{{ route('audit-projects.create') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-sm font-black tracking-[0.15em] text-indigo-900 bg-white rounded-2xl overflow-hidden transition-all hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)]">
                <span class="relative flex items-center gap-2 uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    New Project
                </span>
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-10 shadow-2xl shadow-gray-100/50 border border-gray-100">

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-50/80 backdrop-blur-sm border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-2 bg-emerald-200/50 rounded-xl shrink-0"><svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                <div>
                    <p class="font-black uppercase tracking-widest text-xs mb-1">Success</p>
                    <p class="text-base font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Search Filter Bar -->
        <form action="{{ route('audit-projects.index') }}" method="GET" class="flex flex-col xl:flex-row gap-4 mb-10 items-center justify-between bg-gray-50/50 p-4 rounded-3xl border border-gray-100 shadow-sm relative z-20">
            <div class="relative w-full xl:w-1/3 group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..." 
                    class="w-full pl-12 pr-4 py-4 bg-white border border-transparent rounded-2xl text-base font-bold text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400 group-hover:border-gray-200">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full xl:w-auto flex-1 justify-end">
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-56 px-4 py-4 bg-white border border-transparent rounded-2xl text-sm font-bold text-gray-600 shadow-sm focus:ring-2 focus:ring-indigo-500 hover:border-gray-200 transition-all cursor-pointer truncate">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                @if(request()->anyFilled(['search', 'status']))
                    <a href="{{ route('audit-projects.index') }}" class="flex items-center justify-center px-6 py-4 bg-red-50 text-red-600 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-red-100 transition-colors whitespace-nowrap">
                        Clear
                    </a>
                @endif
            </div>
        </form>

        <!-- Audit Card List -->
        <div class="space-y-4">
            @forelse($audits as $audit)
                <div class="group bg-white border border-gray-100 rounded-[2rem] p-5 lg:p-6 hover:shadow-2xl hover:shadow-indigo-100/40 hover:border-indigo-100 transition-all duration-300 flex flex-col lg:flex-row items-start lg:items-center gap-6 relative overflow-hidden">
                    
                    <!-- Decorative hover accent -->
                    <div class="absolute inset-y-0 left-0 w-1 bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <!-- Title -->
                    <div class="lg:w-1/4">
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Audit Title</p>
                        <a href="{{ route('audit-projects.show', $audit->id) }}" class="text-lg font-black text-gray-900 uppercase tracking-tight hover:text-indigo-600 transition-colors">{{ $audit->title }}</a>
                    </div>

                    <!-- Office -->
                    <div class="lg:w-1/4">
                        <div class="flex items-center gap-2 mb-1">
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Office</p>
                        </div>
                        <p class="text-base font-bold text-gray-700 line-clamp-2 leading-tight">{{ $officeMap[$audit->office_uuid] ?? 'Unknown Office' }}</p>
                    </div>

                    <!-- Status -->
                    <div class="lg:w-1/6">
                        @php
                            $statusColor = match($audit->status) {
                                'completed' => 'green',
                                'ongoing' => 'blue',
                                'pending' => 'orange',
                                default => 'gray'
                            };
                        @endphp
                        <span class="px-4 py-2 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 rounded-xl text-xs font-black uppercase tracking-widest inline-flex items-center gap-2 border border-{{ $statusColor }}-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500 {{ $audit->status === 'ongoing' ? 'animate-pulse' : '' }}"></span>
                            {{ $audit->status }}
                        </span>
                    </div>

                    <!-- Date Range -->
                    <div class="lg:w-1/5">
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Date Range</p>
                        <p class="text-base font-bold text-gray-900">{{ \Carbon\Carbon::parse($audit->start_date)->format('M d, Y') }}</p>
                        <p class="text-sm font-bold text-gray-400 mt-0.5">
                            {{ $audit->end_date ? 'to ' . \Carbon\Carbon::parse($audit->end_date)->format('M d, Y') : 'Ongoing' }}
                        </p>
                    </div>

                    <!-- Auditor -->
                    <div class="lg:w-1/6">
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Auditor</p>
                        <p class="text-base font-bold text-gray-700">{{ $audit->auditor->name ?? 'System' }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="lg:w-auto lg:ml-auto flex items-center gap-2 mt-4 lg:mt-0">
                        <a href="{{ route('audit-projects.show', $audit->id) }}" class="p-4 bg-gray-50 text-gray-500 rounded-2xl hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300" title="View Details">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('audit-projects.edit', $audit->id) }}" class="p-4 bg-gray-50 text-gray-500 rounded-2xl hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300" title="Edit Project">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('audit-projects.destroy', $audit->id) }}" method="POST" class="inline" onsubmit="return confirm('Truly delete this audit project? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-4 bg-gray-50 text-gray-400 rounded-2xl hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-200 transition-all duration-300" title="Delete Project">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-gray-50/50 rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    @if(request()->anyFilled(['search', 'status']))
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">No Results Found</h3>
                        <p class="text-gray-400 text-sm font-medium mt-2">Adjust your search or filters to see more projects.</p>
                        <a href="{{ route('audit-projects.index') }}" class="mt-6 inline-block text-indigo-600 font-bold hover:underline">Clear Filters &rarr;</a>
                    @else
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">No Projects Found</h3>
                        <p class="text-gray-400 text-sm font-medium mt-2">There are currently no active audit projects in the system.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <div class="mt-10 flex justify-center w-full">
            {{ $audits->links() }}
        </div>
    </div>
</x-app-layout>
