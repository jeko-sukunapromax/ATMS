<div x-data="{ show: false }" 
     @confirm-logout.window="show = true" 
     @keydown.escape.window="show = false"
     x-cloak 
     x-show="show" 
     class="relative z-50" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
     
    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/50 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <!-- Modal Panel -->
            <div x-show="show"
                 @click.away="show = false"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md sm:p-10">
                 
                <div class="flex flex-col items-center text-center">
                    <div class="mt-2 mx-auto flex h-24 w-24 items-center justify-center rounded-full border-[3px] border-[#f4b786]">
                        <span class="text-[#eea86c] font-medium text-[50px] leading-none mb-1">!</span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold text-gray-700 tracking-wide" id="modal-title">Ready to Leave?</h3>
                        <div class="mt-4">
                            <p class="text-base text-gray-500 font-medium">You are about to sign out of your account.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 mb-2 flex justify-center gap-3">
                    <form method="POST" action="{{ route('logout') }}" id="logout-modal-form">
                        @csrf
                        <button type="submit" class="inline-flex justify-center rounded bg-[#636b74] px-7 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#525860] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#636b74]">
                            Log Out
                        </button>
                    </form>
                    <button type="button" @click="show = false" class="inline-flex justify-center rounded bg-[#636b74] px-7 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#525860] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#636b74]">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
