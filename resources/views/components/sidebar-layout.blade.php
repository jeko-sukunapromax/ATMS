<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50 overflow-hidden">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" @click="sidebarOpen = false"></div>

        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-white transition ease-in-out duration-300 transform">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <div class="flex-shrink-0 flex items-center px-4">
                    <span class="text-xl font-black text-indigo-600 tracking-tighter uppercase leading-none">Audit Tracking<br>Management System</span>
                </div>
                <nav class="mt-8 px-2 space-y-1">
                    <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">
                        Dashboard
                    </x-sidebar-link>
                    @can('manage-offices')
                    <x-sidebar-link href="{{ route('offices.index') }}" :active="request()->routeIs('offices.*')" icon="office">
                        Offices
                    </x-sidebar-link>
                    @endcan
                    @can('manage-audits')
                    <x-sidebar-link href="{{ route('audit-projects.index') }}" :active="request()->routeIs('audit-projects.*')" icon="audit">
                        Audit Tracking
                    </x-sidebar-link>
                    @endcan
                    @can('manage-users')
                    <x-sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" icon="users">
                        User Management
                    </x-sidebar-link>
                    @endcan
                </nav>
            </div>
            <div class="flex-shrink-0 p-4 border-t border-gray-100 bg-gray-50/50">
                <div class="group block w-full bg-white border border-gray-200 rounded-xl p-3 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                    <div class="flex items-center justify-between w-full">
                        <a href="{{ route('profile.show') }}" class="flex items-center flex-1 min-w-0">
                            <img class="inline-block h-12 w-12 rounded-full object-cover ring-2 ring-white shadow-sm" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            <div class="ml-4 truncate">
                                <p class="text-base font-bold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">{{ Auth::user()->name }}</p>
                                <p class="text-sm font-medium text-gray-500 truncate mt-0.5">View Profile</p>
                            </div>
                        </a>
                        <div x-data class="ml-3">
                            <button type="button" @click="$dispatch('confirm-logout')" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200" title="Sign Out">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0 w-14">
            <!-- Force sidebar to shrink to fit close button -->
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-80">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex flex-col h-0 flex-1 border-r border-gray-100 bg-white shadow-sm">
                <!-- Fixed Header -->
                <div class="flex-shrink-0 pt-10 pb-6 px-10 border-b border-gray-50 bg-white z-10">
                    <div class="flex items-center space-x-4">
                        <div class="h-20 w-20 flex items-center justify-center shrink-0">
                            <x-application-mark class="h-20 w-20" />
                        </div>
                        <span class="text-base font-black text-gray-900 tracking-tight uppercase leading-tight">Audit Tracking<br>Management System</span>
                    </div>
                </div>

                <!-- Scrollable Navigation -->
                <div class="flex-1 overflow-y-auto py-4">
                    <nav class="flex flex-col justify-center min-h-full px-4 space-y-2">
                        <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">
                            Dashboard
                        </x-sidebar-link>
                        @can('manage-offices')
                        <x-sidebar-link href="{{ route('offices.index') }}" :active="request()->routeIs('offices.*')" icon="office">
                            Offices
                        </x-sidebar-link>
                        @endcan
                        @can('manage-audits')
                        <x-sidebar-link href="{{ route('audit-projects.index') }}" :active="request()->routeIs('audit-projects.*')" icon="audit">
                            Audit Tracking
                        </x-sidebar-link>
                        @endcan
                        @can('manage-users')
                        <x-sidebar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" icon="users">
                            User Management
                        </x-sidebar-link>
                        @endcan
                    </nav>
                </div>
                <div class="flex-shrink-0 p-4 border-t border-gray-100 bg-gray-50/50">
                    <div class="group block w-full bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                        <div class="flex items-center justify-between w-full">
                            <a href="{{ route('profile.show') }}" class="flex items-center flex-1 min-w-0">
                                <img class="inline-block h-12 w-12 rounded-full object-cover ring-2 ring-white shadow-sm" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                <div class="ml-4 truncate">
                                    <p class="text-base font-bold text-gray-900 truncate group-hover:text-indigo-600 transition-colors">{{ Auth::user()->name }}</p>
                                    <p class="text-sm font-medium text-gray-500 truncate mt-0.5">View Profile</p>
                                </div>
                            </a>
                            <div x-data class="ml-3">
                                <button type="button" @click="$dispatch('confirm-logout')" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200" title="Sign Out">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative z-10 flex-shrink-0 flex h-24 bg-white border-b border-gray-100 md:hidden">
            <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex items-center">
                    <span class="text-lg font-black text-indigo-600 tracking-tighter uppercase leading-none">Audit Tracking Management System</span>
                </div>
            </div>
        </div>

        <main class="flex-1 relative overflow-y-auto focus:outline-none bg-gray-50/50">
            <div class="{{ isset($header) ? 'pt-0 pb-12' : 'py-12' }}">
                @if (isset($header))
                    <div class="max-w-[95rem] mx-auto px-6 sm:px-8 md:px-16 mb-0">
                        {{ $header }}
                    </div>
                @endif
                <div class="max-w-[95rem] mx-auto px-6 sm:px-8 md:px-16">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</div>
