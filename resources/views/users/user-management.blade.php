<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight uppercase">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-blue-50 sm:rounded-3xl border border-gray-100 p-8">
                
                @if(session('warning'))
                    <div class="mb-6 p-4 bg-orange-100 border-l-4 border-orange-500 text-orange-700 rounded-r-xl shadow-sm">
                        <p class="font-bold uppercase tracking-widest text-xs">Token Required</p>
                        <p class="text-sm font-medium">{{ session('warning') }}</p>
                    </div>
                @endif
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Permanent Users</h3>
                        <p class="text-sm font-bold text-gray-400 mt-1 uppercase tracking-widest">Fetched from iHRI System</p>
                    </div>
                    <div class="bg-blue-50 px-6 py-3 rounded-2xl border border-blue-100">
                        <span class="text-blue-700 font-black text-2xl tracking-tighter">{{ is_array($permanentUsers) ? count($permanentUsers) : 0 }}</span>
                        <span class="text-blue-400 text-xs font-black ml-1 uppercase tracking-widest">Active Users</span>
                    </div>
                </div>

                <div class="overflow-hidden bg-white border border-gray-50 rounded-3xl">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Full Name</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Email Address</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Position</th>
                                <th class="px-8 py-5 text-center text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse($permanentUsers as $user)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0 bg-gradient-to-tr from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-blue-100">
                                                {{ strtoupper(substr($user['name'] ?? 'U', 0, 1)) }}
                                            </div>
                                            <div class="ml-5">
                                                <div class="text-sm font-black text-gray-900 tracking-tight">{{ $user['name'] ?? 'N/A' }}</div>
                                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">System User</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-600 tracking-tight">{{ $user['email'] ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-black uppercase tracking-widest inline-block">
                                            {{ $user['position'] ?? 'PERMANENT' }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-center">
                                        <span class="px-4 py-1.5 inline-flex text-xs leading-5 font-black rounded-full bg-emerald-100 text-emerald-700 uppercase tracking-widest">
                                            ACTIVE
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="bg-gray-50 h-20 w-20 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 font-black text-lg uppercase tracking-tight">Accessing iHRI Directory...</p>
                                        <p class="text-gray-300 text-xs font-bold mt-2 uppercase tracking-widest">No users found or connection in progress.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
