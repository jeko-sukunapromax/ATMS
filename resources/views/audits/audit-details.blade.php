<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <!-- Subtle Decorative background element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-bl-full -z-0 opacity-40 translate-x-10 -translate-y-10"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-none mb-3">
                        Audit Project Details
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-1">
                            <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                            <span class="w-3 h-3 rounded-full bg-indigo-400 opacity-50"></span>
                        </div>
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] ml-1">View Project Insights & Findings</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('audit-projects.index') }}" class="group inline-flex items-center gap-2 px-6 py-3 text-[11px] font-black tracking-[0.2em] text-gray-500 hover:text-indigo-600 bg-gray-50 hover:bg-indigo-50 rounded-xl transition-all duration-300 uppercase">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm animate-bounce">
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Project Overview Card -->
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-3xl p-8 mb-8 border border-gray-50">
                <div class="flex justify-between items-start border-b border-gray-100 pb-8 mb-8">
                    <div>
                        <div class="flex items-center gap-4">
                            <h3 class="text-5xl font-extrabold text-gray-900 tracking-tight">{{ $audit->title }}</h3>
                            <span class="px-4 py-1.5 text-sm font-black uppercase tracking-widest rounded-full 
                                {{ $audit->status == 'completed' ? 'bg-green-500 text-white' : ($audit->status == 'ongoing' ? 'bg-indigo-500 text-white' : 'bg-gray-400 text-white') }} shadow-sm">
                                {{ $audit->status }}
                            </span>
                        </div>
                        <p class="text-indigo-600 font-bold text-2xl mt-3">{{ $officeName }}</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('audit-projects.edit', $audit->id) }}" class="bg-orange-50 text-orange-600 px-6 py-3 rounded-2xl hover:bg-orange-100 transition font-bold text-base flex items-center gap-2">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                             Edit
                        </a>
                        <form action="{{ route('audit-projects.destroy', $audit->id) }}" method="POST" onsubmit="return confirm('Truly delete this audit project?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 text-red-600 px-6 py-3 rounded-2xl hover:bg-red-100 transition font-bold text-base flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div class="bg-indigo-50/50 p-8 rounded-[2rem] border border-indigo-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-indigo-200 p-3 rounded-xl text-indigo-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-sm text-indigo-400 uppercase font-black tracking-widest">Auditor</p>
                        </div>
                        <p class="text-gray-900 font-bold text-2xl">{{ $audit->auditor->name ?? 'System / Unknown' }}</p>
                    </div>
                    
                    <div class="bg-emerald-50/50 p-8 rounded-[2rem] border border-emerald-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-emerald-200 p-3 rounded-xl text-emerald-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-sm text-emerald-400 uppercase font-black tracking-widest">Timeline</p>
                        </div>
                        <p class="text-gray-900 font-bold text-2xl">
                            {{ \Carbon\Carbon::parse($audit->start_date)->format('M d') }} - 
                            {{ $audit->end_date ? \Carbon\Carbon::parse($audit->end_date)->format('M d, Y') : 'Active' }}
                        </p>
                    </div>

                    <div class="bg-purple-50/50 p-8 rounded-[2rem] border border-purple-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-purple-200 p-3 rounded-xl text-purple-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-sm text-purple-400 uppercase font-black tracking-widest">Findings</p>
                        </div>
                        <p class="text-gray-900 font-bold text-2xl">{{ $audit->findings->count() }} Records Found</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-8 rounded-[2rem]">
                    <p class="text-sm text-gray-400 uppercase font-black tracking-widest mb-4">Project Description</p>
                    <p class="text-gray-700 text-lg leading-relaxed font-medium">{{ $audit->description ?: 'This project has no detailed description.' }}</p>
                </div>
            </div>

            <!-- Findings Section -->
            <div class="bg-white overflow-hidden shadow-2xl shadow-gray-100 sm:rounded-3xl p-8 border border-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-10 pb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Findings & Recommendations</h3>
                        <p class="text-base text-gray-500 font-medium mt-1">Manage and track specific issues found during audit.</p>
                    </div>
                    <a href="{{ route('findings.create', $audit->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl text-[13px] font-black uppercase tracking-[0.2em] shadow-lg shadow-indigo-200 transition duration-300 transform hover:-translate-y-1 hover:shadow-indigo-300">
                        + ADD FINDING
                    </a>
                </div>

                <div class="space-y-6">
                    @forelse($audit->findings as $finding)
                        <div class="group bg-white border border-gray-100 rounded-[2rem] p-8 hover:shadow-2xl hover:shadow-indigo-50 hover:border-indigo-100 transition-all duration-300">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-5">
                                    <div class="h-16 w-16 text-2xl rounded-[1.25rem] shadow-sm flex items-center justify-center font-black text-white
                                        {{ $finding->risk_level == 'high' ? 'bg-gradient-to-br from-red-500 to-red-600' : ($finding->risk_level == 'medium' ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gradient-to-br from-emerald-400 to-emerald-500') }}">
                                        {{ strtoupper(substr($finding->risk_level, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ $finding->title }}</h4>
                                        <div class="flex items-center gap-3 mt-2">
                                            <p class="text-sm font-black uppercase tracking-widest flex items-center gap-1.5
                                                {{ $finding->risk_level == 'high' ? 'text-red-600' : ($finding->risk_level == 'medium' ? 'text-orange-600' : 'text-emerald-600') }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $finding->risk_level == 'high' ? 'bg-red-500' : ($finding->risk_level == 'medium' ? 'bg-orange-500' : 'bg-emerald-500') }}"></span>
                                                {{ $finding->risk_level }} risk
                                            </p>
                                            <span class="text-xs font-black uppercase tracking-[0.2em] px-3 py-1 rounded-lg border
                                                {{ $finding->status == 'resolved' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : ($finding->status == 'open' ? 'bg-orange-50 text-orange-700 border-orange-100' : 'bg-gray-50 text-gray-700 border-gray-200') }}">
                                                {{ $finding->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('findings.edit', [$audit->id, $finding->id]) }}" class="text-orange-400 hover:text-orange-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                    <form action="{{ route('findings.destroy', [$audit->id, $finding->id]) }}" method="POST" onsubmit="return confirm('Delete this finding?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium mb-8 leading-relaxed">{{ $finding->description }}</p>
                            
                            <!-- Recommendations Mini-section -->
                            <div class="bg-gray-50/80 rounded-[1.5rem] p-6 border border-gray-100">
                                <div class="flex justify-between items-center mb-6">
                                    <span class="text-sm font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Recommendations
                                    </span>
                                </div>
                                
                                <div class="space-y-4">
                                    @forelse($finding->recommendations as $rec)
                                        <div class="flex items-start justify-between bg-white p-5 rounded-2xl border border-gray-100 shadow-sm group/rec">
                                            <div class="flex items-start gap-4">
                                                <div class="mt-2 shrink-0">
                                                    <div class="h-2.5 w-2.5 rounded-full bg-indigo-500"></div>
                                                </div>
                                                <p class="text-base text-gray-800 font-medium leading-relaxed">{{ $rec->description }}</p>
                                            </div>
                                            <form action="{{ route('recommendations.destroy', [$audit->id, $finding->id, $rec->id]) }}" method="POST" class="shrink-0 ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg opacity-0 group-hover/rec:opacity-100 transition-all">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="bg-white/50 border border-gray-200 border-dashed rounded-2xl p-6 text-center">
                                            <p class="text-base font-bold text-gray-400 italic">No recommendations added yet.</p>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Add Recommendation Form -->
                                <form action="{{ route('recommendations.store', [$audit->id, $finding->id]) }}" method="POST" class="mt-6 flex flex-col sm:flex-row gap-4">
                                    @csrf
                                    <input type="text" name="description" placeholder="Type actionable recommendation..." class="flex-1 bg-white border-gray-200 rounded-2xl text-lg p-5 focus:ring-indigo-500 focus:border-indigo-500 font-medium shadow-sm transition-shadow" required>
                                    <button type="submit" class="bg-indigo-600 text-white px-10 py-5 rounded-2xl text-sm font-black tracking-widest uppercase hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-0.5 transform">ADD</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-gray-50/50 rounded-3xl border-2 border-dashed border-gray-100">
                            <div class="bg-white h-20 w-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 font-black text-lg">READY TO TRACK FINDINGS?</p>
                            <p class="text-gray-300 text-sm mt-2 font-medium">Every great audit starts with a single observation.</p>
                            <a href="{{ route('findings.create', $audit->id) }}" class="mt-6 inline-block text-indigo-600 font-bold hover:underline">Start adding findings &rarr;</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
