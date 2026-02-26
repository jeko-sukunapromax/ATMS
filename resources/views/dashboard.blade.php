<x-app-layout>
    <!-- Page Header (Premium Gradient) -->
    <div class="relative bg-indigo-600 rounded-[2.5rem] overflow-hidden mb-8 shadow-2xl shadow-indigo-200">
        <!-- Decorative blobs -->
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-purple-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute inset-0 bg-[#000] bg-opacity-10 backdrop-blur-[2px]"></div>

        
        <div class="relative z-10 px-10 py-16 sm:px-16 sm:py-20 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-8 md:mb-0">
                <h1 class="text-5xl sm:text-6xl font-black text-white tracking-tight leading-tight">
                    Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FFD700] to-yellow-200">{{ explode(' ', Auth::user()->name)[0] }}</span>!
                </h1>
            </div>
            
            @can('manage-audits')
            <div class="shrink-0 flex items-center justify-center">
                <a href="{{ route('audit-projects.create') }}" class="group relative inline-flex items-center justify-center px-10 py-5 text-sm font-black tracking-[0.2em] text-indigo-900 bg-white rounded-2xl overflow-hidden transition-all hover:scale-105 hover:shadow-[0_0_40px_rgba(255,255,255,0.4)]">
                    <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-[#FFD700] rounded-full group-hover:w-64 group-hover:h-64"></span>
                    <span class="relative flex items-center gap-3 uppercase">
                        <svg class="w-6 h-6 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        New Audit
                    </span>
                </a>
            </div>
            @endcan
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border border-gray-100 transition hover:-translate-y-1 hover:shadow-xl">
            <div class="text-center mb-6">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Total System Users</h3>
            </div>
            <p class="text-6xl font-black text-indigo-600 tracking-tighter text-center">{{ $usersCount }}</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border border-gray-100 transition hover:-translate-y-1 hover:shadow-xl">
            <div class="text-center mb-6">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Audit Projects</h3>
            </div>
            <p class="text-6xl font-black text-indigo-600 tracking-tighter text-center">{{ $auditsCount }}</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border border-gray-100 transition hover:-translate-y-1 hover:shadow-xl">
            <div class="text-center mb-6">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em]">Total Findings</h3>
            </div>
            <p class="text-6xl font-black text-indigo-600 tracking-tighter text-center">{{ $findingsCount }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-10">
        <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest mb-5">Quick Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <a href="{{ route('audit-projects.index') }}" class="group flex flex-col items-center text-center bg-indigo-600 rounded-2xl px-7 py-8 shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                <svg class="w-10 h-10 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-lg font-bold text-white">Manage Audits</p>
                <p class="text-sm text-indigo-200 font-medium mt-1">View & track audit projects</p>
            </a>

            <a href="{{ route('offices.index') }}" class="group flex flex-col items-center text-center bg-indigo-600 rounded-2xl px-7 py-8 shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                <svg class="w-10 h-10 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <p class="text-lg font-bold text-white">Manage Offices</p>
                <p class="text-sm text-indigo-200 font-medium mt-1">View & edit office directory</p>
            </a>

            <a href="{{ route('users.index') }}" class="group flex flex-col items-center text-center bg-indigo-600 rounded-2xl px-7 py-8 shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                <svg class="w-10 h-10 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <p class="text-lg font-bold text-white">Manage Users</p>
                <p class="text-sm text-indigo-200 font-medium mt-1">User access & permissions</p>
            </a>
        </div>
    </div>

    <!-- Dashboard Widgets (Recent Activity & Alerts) -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Column: Recent Audits -->
        <div class="w-full lg:w-2/3 flex flex-col gap-8">
            <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden h-full">
                <!-- Header -->
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tighter">Recent Projects</h3>
                        <p class="text-xs sm:text-sm font-bold text-gray-400 mt-1 uppercase tracking-widest">Latest Audit Activities</p>
                    </div>
                    @can('manage-audits')
                    <a href="{{ route('audit-projects.index') }}" class="px-5 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest transition-colors flex items-center gap-2">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @endcan
                </div>

                <!-- List -->
                <div class="space-y-4">
                    @forelse($recentAudits as $audit)
                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-5 border border-gray-100 rounded-[1.5rem] hover:border-indigo-100 hover:shadow-lg hover:shadow-indigo-50/50 transition-all duration-300 gap-4 cursor-default">
                            <div class="flex items-center gap-4 w-full sm:w-2/3">
                                <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-indigo-50 to-indigo-100 text-indigo-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-base sm:text-lg text-gray-900 truncate" title="{{ $audit->title }}">{{ $audit->title }}</p>
                                    <p class="text-sm font-semibold text-gray-500 mt-1 truncate flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $officeMap[$audit->office_uuid] ?? 'Unknown Office' }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="sm:shrink-0 flex items-center mt-2 sm:mt-0">
                                @php
                                    $statusColor = match($audit->status) {
                                        'completed' => 'green',
                                        'ongoing' => 'blue',
                                        'pending' => 'orange',
                                        default => 'gray'
                                    };
                                @endphp
                                <span class="px-5 py-2.5 bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 rounded-xl text-xs font-black uppercase tracking-[0.1em] border border-{{ $statusColor }}-100 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-{{ $statusColor }}-500 {{ $audit->status === 'ongoing' ? 'animate-pulse' : '' }}"></span>
                                    {{ $audit->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50/50 rounded-[2rem] border-2 border-dashed border-gray-100">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-500">No recent audit projects discovered.</p>
                            @can('manage-audits')
                            <a href="{{ route('audit-projects.create') }}" class="inline-block mt-4 text-[11px] font-black text-indigo-600 hover:underline uppercase tracking-widest">Start New Audit &rarr;</a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Alerts & Charts -->
        <div class="w-full lg:w-1/3 flex flex-col gap-8">
            
            <!-- Audit Status Chart Background/Card -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative group transition-all duration-300 hover:shadow-indigo-50/50">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Status Overview</h4>
                    <div class="p-1.5 bg-gray-50 rounded-lg">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                </div>
                <!-- Div for Chart.js -->
                <div class="relative h-48 w-full flex items-center justify-center mt-4">
                    <canvas id="auditStatusChart"></canvas>
                </div>
            </div>

            <!-- High Risk Alerts Card -->
            <div class="bg-gradient-to-br from-red-50 to-orange-50 border border-red-100 rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)] h-full overflow-hidden relative">
                <!-- Diagonal Pattern Background -->
                <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiAvPgo8cGF0aCBkPSJNMCAwTDggOFpNOCAwTDAgOFoiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLXdpZHRoPSIxIiAvPgo8L3N2Zz4=')]"></div>
                
                <div class="relative z-10 flex items-center justify-between gap-3 mb-6 pb-4 border-b border-red-200/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 shadow-md shadow-red-200 flex items-center justify-center shrink-0 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-red-900 tracking-tight">Critical Risks</h3>
                            <p class="text-xs font-black text-red-500 mt-1 uppercase tracking-widest flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> Needs Action</p>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 space-y-3">
                    @forelse($highRiskFindings as $finding)
                        <div class="bg-white/80 backdrop-blur-sm p-5 rounded-2xl border border-red-100 shadow-sm hover:-translate-y-1 transition-transform duration-300">
                            <p class="text-sm font-bold text-gray-900 line-clamp-2 leading-tight">{{ $finding->title }}</p>
                            @can('manage-audits')
                            <a href="{{ route('audit-projects.show', $finding->audit_id) }}" class="inline-block mt-3 text-xs font-black text-red-600 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100 uppercase tracking-widest hover:bg-red-600 hover:text-white transition-colors">
                                {{ \Illuminate\Support\Str::limit($finding->audit->title ?? 'View Audit', 25) }} &rarr;
                            </a>
                            @else
                            <p class="mt-3 text-xs font-black text-red-600 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100 uppercase tracking-widest inline-block">
                                {{ \Illuminate\Support\Str::limit($finding->audit->title ?? 'Audit Project', 25) }}
                            </p>
                            @endcan
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner shadow-white/50 border border-green-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-xs font-black text-green-700 uppercase tracking-widest mb-1">Clear</p>
                            <p class="text-[10px] font-bold text-green-600/70">No high-risk findings recorded.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @push('modals')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('auditStatusChart').getContext('2d');
            const dataLabels = {!! json_encode($chartData['labels']) !!};
            const dataValues = {!! json_encode($chartData['data']) !!};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: dataLabels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: [
                            '#F59E0B', // Pending - Amber
                            '#3B82F6', // Ongoing - Blue
                            '#10B981'  // Completed - Green
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 11,
                                    weight: '600'
                                },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
