<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight uppercase">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="h-full flex flex-col">
        <div class="bg-white shadow-2xl shadow-gray-100 sm:rounded-lg border border-transparent p-10 flex-1">
        
        @if(session('warning'))
            <div class="mb-8 p-6 bg-orange-50 border-l-4 border-orange-500 text-orange-700 rounded-lg shadow-sm">
                <p class="font-black uppercase tracking-widest text-[10px]">Action Required</p>
                <p class="text-sm font-bold mt-1">{{ session('warning') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-lg shadow-sm">
                <p class="font-black uppercase tracking-widest text-[10px]">Success</p>
                <p class="text-sm font-bold mt-1">{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div>
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Local Directory</h3>
                    <p class="text-[11px] font-black text-gray-400 mt-1 uppercase tracking-widest">Synced via iHRI System</p>
                </div>
                <!-- Stats Pill -->
                <div class="hidden md:flex bg-indigo-50 px-4 py-2 rounded-lg border border-transparent items-center">
                    <span class="text-indigo-600 font-black text-lg tracking-tighter">{{ count($permanentUsers) }}</span>
                    <span class="text-indigo-300 text-[10px] font-black ml-2 uppercase tracking-widest">Records</span>
                </div>
            </div>

            <!-- Horizontal Filters -->
            <form action="{{ route('users.index') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4 items-center justify-end">
                <div class="relative w-full md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." 
                        class="w-full pl-10 pr-4 py-3 bg-gray-50/50 border border-gray-100 rounded-lg text-xs font-bold text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-400">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <div class="w-full md:w-48">
                    <select name="position" onchange="this.form.submit()" 
                        class="w-full px-4 py-3 bg-gray-50/50 border border-gray-100 rounded-lg text-xs font-bold text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all cursor-pointer">
                        <option value="">All Positions</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($pos, 20) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-48">
                    <select name="office" onchange="this.form.submit()" 
                        class="w-full px-4 py-3 bg-gray-50/50 border border-gray-100 rounded-lg text-xs font-bold text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all cursor-pointer">
                        <option value="">All Offices</option>
                        @foreach($offices as $off)
                            <option value="{{ $off }}" {{ request('office') == $off ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($off, 20) }}</option>
                        @endforeach
                    </select>
                </div>
                
                @if(request()->anyFilled(['search', 'position', 'office']))
                    <a href="{{ route('users.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-hidden bg-white border border-gray-100 rounded-lg shadow-sm">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Full Name</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Email Address</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Position</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Office / Department</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">Role</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($permanentUsers as $user)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-gray-900 block tracking-tight uppercase">{{ $user->name }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">ID: {{ substr($user->ihri_uuid, 0, 8) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-gray-500">{{ $user->email }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest inline-block">
                                    {{ $user->position ?: 'N/A' }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-gray-600">{{ $user->office ?: 'N/A' }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-[10px] font-black uppercase tracking-widest inline-block">
                                    {{ $user->getRoleNames()->first() ?: 'User' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-widest transition-colors">Edit</a>
                                    
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this user from the local directory? This will not delete them from iHRI.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-widest transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                @if(request()->anyFilled(['search', 'position', 'office']))
                                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">No Results Found</h3>
                                    <p class="text-gray-400 text-xs font-bold mt-2 uppercase tracking-widest">Adjust your filters to see more people.</p>
                                @else
                                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Directory Empty</h3>
                                    <p class="text-gray-400 text-xs font-bold mt-2 uppercase tracking-widest">Initial sync might be in progress.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/30 flex justify-center w-full">
                {{ $permanentUsers->links() }}
            </div>
        </div>
        </div>
    </div>
</x-app-layout>
