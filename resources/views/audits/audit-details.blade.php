<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Audit Project Details') }}
            </h2>
            <a href="{{ route('audit-projects.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition">&larr; Back to Dashboard</a>
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
                <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $audit->title }}</h3>
                            <span class="px-3 py-1 text-xs font-black uppercase tracking-widest rounded-full 
                                {{ $audit->status == 'completed' ? 'bg-green-500 text-white' : ($audit->status == 'ongoing' ? 'bg-indigo-500 text-white' : 'bg-gray-400 text-white') }}">
                                {{ $audit->status }}
                            </span>
                        </div>
                        <p class="text-indigo-600 font-bold text-lg mt-2">{{ $officeName }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('audit-projects.edit', $audit->id) }}" class="bg-orange-50 text-orange-600 px-4 py-2 rounded-xl hover:bg-orange-100 transition font-bold text-sm flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                             Edit
                        </a>
                        <form action="{{ route('audit-projects.destroy', $audit->id) }}" method="POST" onsubmit="return confirm('Truly delete this audit project?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 text-red-600 px-4 py-2 rounded-xl hover:bg-red-100 transition font-bold text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div class="bg-indigo-50/50 p-5 rounded-2xl border border-indigo-100">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-indigo-200 p-2 rounded-lg text-indigo-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-xs text-indigo-400 uppercase font-black tracking-widest">Auditor</p>
                        </div>
                        <p class="text-gray-900 font-bold text-lg">{{ $audit->auditor->name ?? 'System / Unknown' }}</p>
                    </div>
                    
                    <div class="bg-emerald-50/50 p-5 rounded-2xl border border-emerald-100">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-emerald-200 p-2 rounded-lg text-emerald-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-xs text-emerald-400 uppercase font-black tracking-widest">Timeline</p>
                        </div>
                        <p class="text-gray-900 font-bold text-lg">
                            {{ \Carbon\Carbon::parse($audit->start_date)->format('M d') }} - 
                            {{ $audit->end_date ? \Carbon\Carbon::parse($audit->end_date)->format('M d, Y') : 'Active' }}
                        </p>
                    </div>

                    <div class="bg-purple-50/50 p-5 rounded-2xl border border-purple-100">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-purple-200 p-2 rounded-lg text-purple-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <p class="text-xs text-purple-400 uppercase font-black tracking-widest">Findings</p>
                        </div>
                        <p class="text-gray-900 font-bold text-lg">{{ $audit->findings->count() }} Records Found</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-3">Project Description</p>
                    <p class="text-gray-700 leading-relaxed font-medium">{{ $audit->description ?: 'This project has no detailed description.' }}</p>
                </div>
            </div>

            <!-- Findings Section -->
            <div class="bg-white overflow-hidden shadow-2xl shadow-gray-100 sm:rounded-3xl p-8 border border-gray-50">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900">Findings & Recommendations</h3>
                        <p class="text-sm text-gray-500 font-medium">Manage and track specific issues found during audit.</p>
                    </div>
                    <a href="{{ route('findings.create', $audit->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl text-sm font-black shadow-lg shadow-indigo-200 transition duration-300 transform hover:-translate-y-1">
                        + ADD FINDING
                    </a>
                </div>

                <div class="space-y-6">
                    @forelse($audit->findings as $finding)
                        <div class="group bg-white border border-gray-100 rounded-3xl p-6 hover:shadow-xl hover:border-indigo-100 transition duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-2xl flex items-center justify-center font-black text-white
                                        {{ $finding->risk_level == 'high' ? 'bg-red-500' : ($finding->risk_level == 'medium' ? 'bg-orange-500' : 'bg-emerald-500') }}">
                                        {{ strtoupper(substr($finding->risk_level, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-extrabold text-gray-900">{{ $finding->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <p class="text-xs font-black uppercase tracking-widest 
                                                {{ $finding->risk_level == 'high' ? 'text-red-500' : ($finding->risk_level == 'medium' ? 'text-orange-500' : 'text-emerald-500') }}">
                                                {{ $finding->risk_level }} risk
                                            </p>
                                            <span class="text-xs font-black uppercase tracking-widest px-2 py-0.5 rounded
                                                {{ $finding->status == 'resolved' ? 'bg-indigo-100 text-indigo-700' : ($finding->status == 'open' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700') }}">
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
                            <p class="text-gray-600 font-medium mb-6 leading-relaxed">{{ $finding->description }}</p>
                            
                            <!-- Recommendations Mini-section -->
                            <div class="bg-gray-50 rounded-2xl p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Recommendations</span>
                                </div>
                                
                                @forelse($finding->recommendations as $rec)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0 group/rec">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1">
                                                <div class="h-2 w-2 rounded-full bg-indigo-400"></div>
                                            </div>
                                            <p class="text-sm text-gray-700 font-medium">{{ $rec->description }}</p>
                                        </div>
                                        <form action="{{ route('recommendations.destroy', [$audit->id, $finding->id, $rec->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-300 hover:text-red-500 opacity-0 group-hover/rec:opacity-100 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic mb-4">No recommendations added yet.</p>
                                @endforelse

                                <!-- Add Recommendation Form -->
                                <form action="{{ route('recommendations.store', [$audit->id, $finding->id]) }}" method="POST" class="mt-4 flex gap-2">
                                    @csrf
                                    <input type="text" name="description" placeholder="Type recommendation..." class="flex-1 bg-white border-gray-200 rounded-xl text-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium" required>
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-black hover:bg-indigo-700 transition">ADD</button>
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
