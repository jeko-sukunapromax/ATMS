<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight">
                    {{ __('Audit Tracking') }}
                </h2>
                <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">Manage All Audit Projects</p>
            </div>
            <a href="{{ route('audit-projects.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-[10px] font-black tracking-[0.2em] text-white bg-indigo-600 rounded-xl overflow-hidden transition-all hover:scale-[1.02] hover:shadow-[0_8px_30px_rgba(79,70,229,0.3)] border-none">
                <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-indigo-500 rounded-full group-hover:w-56 group-hover:h-56 -z-10"></span>
                <span class="relative flex items-center gap-2 uppercase z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    New Project
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-[2.5rem] p-8 border border-gray-50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 bg-white text-left text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Audit Title & Office</th>
                                <th class="px-6 py-4 bg-white text-left text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Status</th>
                                <th class="px-6 py-4 bg-white text-left text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Date Range</th>
                                <th class="px-6 py-4 bg-white text-left text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Auditor</th>
                                <th class="px-6 py-4 bg-white text-right text-[11px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse($audits as $audit)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500 shrink-0 group-hover:scale-110 transition-transform">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <div>
                                                <a href="{{ route('audit-projects.show', $audit->id) }}" class="text-sm font-black text-gray-900 hover:text-indigo-600 transition-colors block mb-0.5">{{ $audit->title }}</a>
                                                <p class="text-[11px] font-bold text-gray-500 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    {{ $audit->office_name ?: 'Unknown Office' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $statusColor = match($audit->status) {
                                                'completed' => 'green',
                                                'ongoing' => 'blue',
                                                'pending' => 'orange',
                                                default => 'gray'
                                            };
                                        @endphp
                                        <span class="px-3 py-1.5 inline-flex bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 rounded-lg text-[10px] font-black uppercase tracking-widest items-center gap-1.5 border border-{{ $statusColor }}-100 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500 {{ $audit->status === 'ongoing' ? 'animate-pulse' : '' }}"></span>
                                            {{ $audit->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-gray-900">{{ \Carbon\Carbon::parse($audit->start_date)->format('M d, Y') }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 tracking-wider">
                                                {{ $audit->end_date ? 'to ' . \Carbon\Carbon::parse($audit->end_date)->format('M d, Y') : 'Ongoing' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($audit->auditor->name ?? 'A') }}&color=4F46E5&background=EEF2FF&rounded=true&bold=true&size=32" alt="Auditor" class="w-6 h-6 rounded-full border border-gray-100">
                                            <span class="text-xs font-bold text-gray-700">{{ $audit->auditor->name ?? 'System' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('audit-projects.show', $audit->id) }}" class="p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('audit-projects.edit', $audit->id) }}" class="p-2 text-orange-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Edit Project">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('audit-projects.destroy', $audit->id) }}" method="POST" class="inline" onsubmit="return confirm('Truly delete this audit project? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete Project">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-gray-200">
                                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">No Projects Found</h3>
                                            <p class="text-[11px] font-bold text-gray-400 mt-2 tracking-wider">There are currently no active audit projects in the system.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
