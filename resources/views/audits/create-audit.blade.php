<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <!-- Subtle Decorative background element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-bl-full -z-0 opacity-40 translate-x-10 -translate-y-10"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-none mb-3">
                        Create Audit Project
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-1">
                            <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                            <span class="w-3 h-3 rounded-full bg-indigo-400 opacity-50"></span>
                        </div>
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] ml-1">Launch New Audit Engagement</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('audit-projects.index') }}" class="group inline-flex items-center gap-2 px-6 py-3 text-[11px] font-black tracking-[0.2em] text-gray-500 hover:text-indigo-600 bg-gray-50 hover:bg-indigo-50 rounded-xl transition-all duration-300 uppercase">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('audit-projects.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700">Audit Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div>
                            <label for="office_uuid" class="block text-sm font-medium text-gray-700">Target Office (from iHRI)</label>
                            <select name="office_uuid" id="office_uuid" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Select Office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office['uuid'] }}">{{ $office['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Expected End Date</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('audit-projects.index') }}" class="mr-4 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
