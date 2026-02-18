<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight tracking-tight uppercase">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- User Stats Card -->
        <div class="bg-indigo-600 overflow-hidden shadow-xl shadow-indigo-100 sm:rounded-3xl p-10 text-white relative">
            <div class="relative z-10">
                <h3 class="text-indigo-100 text-xs font-black uppercase tracking-widest mb-1">Total Users</h3>
                <p class="text-5xl font-black tracking-tighter">{{ \App\Models\User::count() }}</p>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>

        <!-- Projects Stats Card -->
        <div class="bg-white overflow-hidden shadow-2xl shadow-gray-100 sm:rounded-3xl p-10 border border-transparent relative">
            <h3 class="text-gray-400 text-xs font-black uppercase tracking-widest mb-1">Audit Projects</h3>
            <p class="text-5xl font-black text-gray-900 tracking-tighter">{{ \App\Models\Audit::count() }}</p>
        </div>

        <!-- Findings Stats Card -->
        <div class="bg-white overflow-hidden shadow-2xl shadow-gray-100 sm:rounded-3xl p-10 border border-transparent relative">
            <h3 class="text-gray-400 text-xs font-black uppercase tracking-widest mb-1">Total Findings</h3>
            <p class="text-5xl font-black text-gray-900 tracking-tighter">{{ \App\Models\Finding::count() }}</p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-2xl shadow-gray-100 sm:rounded-3xl border border-transparent p-10">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight uppercase">Audit Tracking System</h2>
                <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mt-1">Management Overview</p>
            </div>
            <a href="{{ route('audit-projects.create') }}" class="px-8 py-4 bg-indigo-600 text-white font-black text-[11px] uppercase tracking-widest rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                New Audit
            </a>
        </div>
        
        <div class="bg-gray-50/50 rounded-[2.5rem] p-16 text-center border-2 border-dashed border-gray-100">
            <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-sm">
                <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Welcome to ATMS</h3>
            <p class="text-gray-400 text-sm font-bold max-w-sm mx-auto mt-4 uppercase tracking-widest leading-loose">
                Navigate to the modules on the sidebar to manage users, track audits, and generate findings.
            </p>
        </div>
    </div>
</x-app-layout>
