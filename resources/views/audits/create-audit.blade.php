<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-gradient-to-r from-indigo-900 via-blue-900 to-indigo-800 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl shadow-blue-900/20 overflow-hidden">
            <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[150%] bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[150%] bg-purple-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute inset-0 bg-[#000] bg-opacity-10 backdrop-blur-[2px]"></div>

            <a href="{{ route('audit-projects.index') }}" class="absolute top-6 left-6 w-12 h-12 rounded-full border-2 border-white/30 bg-white/10 hover:bg-white/20 text-white flex items-center justify-center backdrop-blur-md transition-all z-20" title="Back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </a>

            <div class="relative z-10 flex flex-col items-center justify-center gap-4 text-center">
                <h2 class="text-3xl font-black text-white tracking-tight leading-none">
                    Create Audit Project
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="pt-0 pb-12">
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
