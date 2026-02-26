<x-app-layout>
    <!-- Page Header -->
    <div class="relative bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-indigo-200 overflow-hidden mb-8">
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-indigo-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

        <div class="relative z-10 flex items-center justify-between">
            <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                Offices Management
            </h2>
            <a href="{{ route('offices.create') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-sm font-black tracking-[0.15em] text-indigo-900 bg-white rounded-2xl overflow-hidden transition-all hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)]">
                <span class="relative flex items-center gap-2 uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Add New Office
                </span>
            </a>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="mb-8">
        <form method="GET" action="{{ route('offices.index') }}" class="flex flex-col xl:flex-row gap-4 items-center justify-between bg-gray-50/50 p-4 rounded-3xl border border-gray-100 shadow-sm relative z-20">

            {{-- Search --}}
            <div class="relative w-full xl:w-1/3 group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or acronym..."
                    class="w-full pl-12 pr-4 py-4 bg-white border border-transparent rounded-2xl text-base font-bold text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400 group-hover:border-gray-200">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Right-side filters --}}
            <div class="flex flex-col sm:flex-row gap-4 w-full xl:w-auto flex-1 justify-end">

                <select name="office" onchange="this.form.submit()" class="w-full sm:w-64 px-4 py-4 bg-white border border-transparent rounded-2xl text-sm font-bold text-gray-600 shadow-sm focus:ring-2 focus:ring-indigo-500 hover:border-gray-200 transition-all cursor-pointer truncate">
                    <option value="">All Offices</option>
                    @foreach($allOffices as $o)
                        <option value="{{ $o->name }}" {{ request('office') == $o->name ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($o->name, 30) }}</option>
                    @endforeach
                </select>

                @if(request()->anyFilled(['search', 'office']))
                    <a href="{{ route('offices.index') }}" class="flex items-center justify-center px-6 py-4 bg-red-50 text-red-600 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-red-100 transition-colors whitespace-nowrap">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Office Cards Grid -->
    <div class="pt-0 pb-12">
        <div class="sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-sm font-bold flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @forelse($offices as $office)
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 relative"
                         x-data="{ 
                            showMembers: false,
                            showDetails: false,
                            employees: [], 
                            loading: false, 
                            loaded: false, 
                            count: '...',
                            toggleMembers() {
                                this.showMembers = !this.showMembers;
                                this.showDetails = false;
                                if (!this.loaded && this.showMembers) {
                                    this.loading = true;
                                    fetch('{{ route('offices.employee-count', $office->uuid) }}')
                                        .then(r => r.json())
                                        .then(data => {
                                            this.employees = data.employees || [];
                                            this.count = data.count;
                                            this.loading = false;
                                            this.loaded = true;
                                        })
                                        .catch(() => { this.loading = false; this.count = '?'; });
                                }
                            },
                            toggleDetails() {
                                this.showDetails = !this.showDetails;
                                this.showMembers = false;
                            }
                         }"
                         x-init="fetch('{{ route('offices.employee-count', $office->uuid) }}')
                                    .then(r => r.json())
                                    .then(data => count = data.count)
                                    .catch(() => count = '?')">
                        
                        <!-- Blue left accent bar -->
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-indigo-500 rounded-r"></div>

                        <div class="pl-8 pr-8 pt-7 pb-6">
                            <!-- Header: Name + Active Badge -->
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900 leading-tight">{{ $office->name }}</h4>
                                    <p class="text-base text-gray-400 font-semibold mt-1">{{ $office->acronym ?? '' }}</p>
                                </div>
                                <span class="text-base font-bold text-emerald-500 shrink-0 ml-4">Active</span>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center gap-4 mt-3 text-base text-gray-500 font-medium">
                                <span class="text-indigo-600 font-bold"><span x-text="count"></span> members</span>
                            </div>

                            <!-- Footer: View · Edit · Delete  |  Members ↓ -->
                            <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-100">
                                <div class="flex items-center gap-7">
                                    <button @click="toggleDetails()" class="text-base font-semibold text-gray-500 hover:text-indigo-600 transition-colors bg-transparent border-none cursor-pointer p-0 m-0" :class="showDetails ? 'text-indigo-600' : ''">View</button>
                                    <a href="{{ route('offices.edit', $office->id) }}" class="text-base font-semibold text-gray-500 hover:text-indigo-600 transition-colors">Edit</a>
                                    <form action="{{ route('offices.destroy', $office->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this office?');" class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-base font-semibold text-gray-500 hover:text-red-600 transition-colors bg-transparent border-none cursor-pointer p-0 m-0">Delete</button>
                                    </form>
                                </div>

                                <!-- Members Dropdown Toggle -->
                                <button 
                                    @click="toggleMembers()"
                                    class="flex items-center gap-2 text-base font-bold text-indigo-600 hover:text-indigo-800 transition-colors bg-transparent border border-indigo-200 rounded-xl px-5 py-2.5 cursor-pointer hover:bg-indigo-50"
                                    :class="showMembers ? 'bg-indigo-50 border-indigo-300' : ''">
                                    Members
                                    <svg class="w-5 h-5 transition-transform duration-200" :class="showMembers ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Expanded Office Details (View) -->
                        <div x-show="showDetails" x-collapse x-cloak class="border-t border-gray-100">
                            <div class="px-7 py-5 bg-gray-50/50 space-y-3">
                                <div class="grid grid-cols-2 gap-5">
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Office Name</p>
                                        <p class="text-base font-bold text-gray-800">{{ $office->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Acronym</p>
                                        <p class="text-base font-bold text-gray-800">{{ $office->acronym ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">UUID</p>
                                        <p class="text-sm font-mono text-gray-600 break-all">{{ $office->uuid }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Source</p>
                                        @if($office->is_local)
                                            <span class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-md uppercase tracking-wider">Local (ATMS)</span>
                                        @else
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-md uppercase tracking-wider">iHRIS API</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expanded Members List (Inline Dropdown) -->
                        <div x-show="showMembers" x-collapse x-cloak class="border-t border-gray-100">
                            
                            <!-- Loading State -->
                            <template x-if="loading">
                                <div class="flex items-center justify-center py-8 gap-2 text-sm text-gray-400">
                                    <svg class="w-5 h-5 animate-spin text-indigo-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    Loading members...
                                </div>
                            </template>

                            <!-- Employee List -->
                            <template x-if="loaded && !loading">
                                <div class="max-h-[400px] overflow-y-auto">
                                    <template x-if="employees.length === 0">
                                        <div class="px-7 py-6 text-center text-sm text-gray-400 font-medium">No employees found for this office.</div>
                                    </template>

                                    <template x-for="(emp, index) in employees" :key="index">
                                        <div class="flex items-center justify-between px-7 py-4 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-b-0">
                                            <div class="flex items-center min-w-0">
                                                <div class="min-w-0">
                                                    <p class="text-base font-bold text-gray-800 truncate" x-text="emp.name"></p>
                                                    <p class="text-sm text-gray-400 truncate" x-text="emp.position"></p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold text-emerald-500 uppercase tracking-wider bg-emerald-50 px-3 py-1.5 rounded-md shrink-0 ml-3">Employee</span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-200 border-dashed">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-bold">No offices found.</p>
                        <p class="text-gray-400 text-sm mt-2">Add a new office or check your API connection.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $offices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
