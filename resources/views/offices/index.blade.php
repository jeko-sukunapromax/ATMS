<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <!-- Subtle Decorative background element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-bl-full -z-0 opacity-40 translate-x-10 -translate-y-10"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-none mb-3">
                        Offices Management
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-1">
                            <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                            <span class="w-3 h-3 rounded-full bg-blue-400 opacity-50"></span>
                        </div>
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] ml-1">Live Organizational Structure</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">List of Offices</h3>
                        <p class="text-sm text-gray-600">Select an office to view its employees.</p>
                    </div>

                    <form method="GET" action="{{ route('offices.index') }}" class="relative w-full md:w-1/3">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or acronym..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @if(request()->filled('search'))
                            <a href="{{ route('offices.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($offices as $office)
                        <div class="bg-white border border-gray-100 rounded-3xl p-8 hover:shadow-2xl hover:shadow-indigo-50 hover:border-indigo-100 transition-all duration-300 flex flex-col items-center justify-center text-center min-h-[220px]">
                            <h4 class="text-xl font-black text-gray-900 mb-2 leading-tight">{{ $office['name'] ?? 'Unknown Office' }}</h4>
                            
                            <p class="text-sm font-bold text-gray-400 mb-8 uppercase tracking-widest"
                               x-data="{ count: '...' }" 
                               x-init="fetch('{{ route('offices.employee-count', $office['uuid'] ?? 0) }}')
                                           .then(res => res.json())
                                           .then(data => count = data.count)
                                           .catch(() => count = '?')">
                                <span x-text="count"></span> Employees
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('offices.show', $office['uuid'] ?? 0) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-black tracking-widest uppercase text-xs transition-colors group">
                                    View Employees
                                    <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg">No offices found or API connection failed.</p>
                            <p class="text-gray-400 text-sm mt-2">Check your IHRI_API_URL and ensure you are logged in correctly.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
