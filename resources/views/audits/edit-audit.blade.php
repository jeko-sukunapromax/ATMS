<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Audit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-3xl p-8 border border-gray-50">
                <form action="{{ route('audit-projects.update', $audit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Side -->
                        <div class="space-y-6">
                            <div>
                                <x-label for="title" value="{{ __('Project Title') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <x-input id="title" name="title" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4" :value="old('title', $audit->title)" required />
                                <x-input-error for="title" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="office_uuid" value="{{ __('Target Office (Department)') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <select id="office_uuid" name="office_uuid" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer">
                                    <option value="">Select Office</option>
                                    @foreach($offices as $office)
                                        <option value="{{ $office['uuid'] }}" {{ old('office_uuid', $audit->office_uuid) == $office['uuid'] ? 'selected' : '' }}>
                                            {{ $office['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="office_uuid" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="status" value="{{ __('Project Status') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <select id="status" name="status" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer">
                                    <option value="pending" {{ old('status', $audit->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ongoing" {{ old('status', $audit->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status', $audit->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <x-input-error for="status" class="mt-2" />
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label for="start_date" value="{{ __('Start Date') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                    <x-input id="start_date" name="start_date" type="date" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4" :value="old('start_date', $audit->start_date)" required />
                                    <x-input-error for="start_date" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="end_date" value="{{ __('End Date (Optional)') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                    <x-input id="end_date" name="end_date" type="date" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4" :value="old('end_date', $audit->end_date)" />
                                    <x-input-error for="end_date" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-label for="description" value="{{ __('Detailed Description') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <textarea id="description" name="description" rows="5" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-gray-600 outline-none">{{ old('description', $audit->description) }}</textarea>
                                <x-input-error for="description" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4">
                        <a href="{{ route('audit-projects.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition">Cancel</a>
                        <x-button class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-white font-black text-xs tracking-widest shadow-xl shadow-indigo-200 transform hover:-translate-y-1 transition-all border-none">
                            {{ __('UPDATE PROJECT') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
