<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Finding') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Project: {{ $audit->title }}</h3>
                    <p class="text-sm text-gray-500">Document your audit finding below.</p>
                </div>

                <form action="{{ route('findings.store', $audit->id) }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <input type="hidden" name="status" value="open">
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Finding Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3" placeholder="e.g., Missing Invoice Documentation" required>
                        </div>

                        <div>
                            <label for="riskLevel" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Risk Level</label>
                            <select name="riskLevel" id="riskLevel" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3" required>
                                <option value="low">Low Risk</option>
                                <option value="medium" selected>Medium Risk</option>
                                <option value="high">High Risk</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Detailed Description</label>
                            <textarea name="description" id="description" rows="5" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3" placeholder="Provide a detailed explanation of the finding..." required></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('audit-projects.show', $audit->id) }}" class="px-6 py-3 text-sm font-bold text-gray-500 bg-gray-50 hover:bg-gray-100 rounded-xl transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-200 transition duration-200">
                            Save Finding
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
