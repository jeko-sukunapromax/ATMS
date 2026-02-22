<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Finding') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-100 sm:rounded-3xl p-8 border border-gray-50">
                <form action="{{ route('findings.update', [$audit->id, $finding->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <x-label for="title" value="{{ __('Finding Title') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                            <x-input id="title" name="title" type="text" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4" :value="old('title', $finding->title)" required autofocus />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-label for="riskLevel" value="{{ __('Risk Level') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <select id="riskLevel" name="riskLevel" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer font-bold">
                                    <option value="low" {{ old('riskLevel', $finding->risk_level) == 'low' ? 'selected' : '' }}>LOW RISK</option>
                                    <option value="medium" {{ old('riskLevel', $finding->risk_level) == 'medium' ? 'selected' : '' }}>MEDIUM RISK</option>
                                    <option value="high" {{ old('riskLevel', $finding->risk_level) == 'high' ? 'selected' : '' }}>HIGH RISK</option>
                                </select>
                                <x-input-error for="riskLevel" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="status" value="{{ __('Resolution Status') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                                <select id="status" name="status" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer font-bold">
                                    <option value="open" {{ old('status', $finding->status) == 'open' ? 'selected' : '' }}>OPEN (Needs Action)</option>
                                    <option value="resolved" {{ old('status', $finding->status) == 'resolved' ? 'selected' : '' }}>RESOLVED (Fixed)</option>
                                    <option value="closed" {{ old('status', $finding->status) == 'closed' ? 'selected' : '' }}>CLOSED (Discarded)</option>
                                </select>
                                <x-input-error for="status" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-label for="description" value="{{ __('Observation / Description') }}" class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1 ml-1" />
                            <textarea id="description" name="description" rows="6" class="block w-full bg-gray-50 border-gray-100 rounded-2xl p-4 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-gray-600 outline-none" required>{{ old('description', $finding->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end gap-4">
                        <a href="{{ route('audit-projects.show', $audit->id) }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition">Cancel</a>
                        <x-button class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-white font-black text-xs tracking-widest shadow-xl shadow-indigo-200 transform hover:-translate-y-1 transition-all border-none">
                            {{ __('UPDATE FINDING') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
