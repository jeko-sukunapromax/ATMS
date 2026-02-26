<?php

namespace App\Http\Controllers;

use App\Services\IHRIService;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    protected $ihriService;

    public function __construct(IHRIService $ihriService)
    {
        $this->ihriService = $ihriService;
    }

    public function index(Request $request)
    {
        $token = session('ihri_token');

        // Fetch offices from iHRIS API and save/sync to local database
        if ($token) {
            $response = $this->ihriService->getOffices($token);
            $apiOffices = $response['data'] ?? $response ?? [];

            foreach ($apiOffices as $apiOffice) {
                if (!empty($apiOffice['uuid'])) {
                    \App\Models\Office::updateOrCreate(
                        ['uuid' => $apiOffice['uuid']],
                        [
                            'name' => $apiOffice['name'] ?? 'Unknown',
                            'acronym' => $apiOffice['acronym'] ?? null,
                            'is_local' => false,
                        ]
                    );
                }
            }
        }

        // Load all offices from local database
        $query = \App\Models\Office::orderBy('name');

        // Apply filtering
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('acronym', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('source')) {
            $source = $request->input('source');
            if ($source === 'local') {
                $query->where('is_local', true);
            } elseif ($source === 'synced') {
                $query->where('is_local', false);
            }
        }

        // Filter by specific office name
        if ($request->filled('office')) {
            $query->where('name', $request->input('office'));
        }

        $offices = $query->paginate(10)->withQueryString();

        // Full unfiltered list for the dropdown
        $allOffices = \App\Models\Office::orderBy('name')->get();

        return view('offices.index', compact('offices', 'allOffices'));
    }

    public function create()
    {
        return view('offices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:50',
        ]);

        \App\Models\Office::create([
            'name' => $validated['name'],
            'acronym' => $validated['acronym'],
            'is_local' => true,
        ]);

        return redirect()->route('offices.index')->with('success', 'Office added successfully.');
    }

    public function edit($id)
    {
        $office = \App\Models\Office::findOrFail($id);
        return view('offices.edit', compact('office'));
    }

    public function update(Request $request, $id)
    {
        $office = \App\Models\Office::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:50',
        ]);

        $office->update($validated);

        return redirect()->route('offices.index')->with('success', 'Office updated successfully.');
    }

    public function destroy($id)
    {
        $office = \App\Models\Office::findOrFail($id);
        $office->delete();

        return redirect()->route('offices.index')->with('success', 'Office removed successfully.');
    }

    public function show($uuid, Request $request)
    {
        $token = session('ihri_token');
        
        if (!$token) {
            return redirect()->route('login');
        }

        $employees = $this->ihriService->getEmployeesByOffice($uuid, $token);
        $employees = $employees['data'] ?? $employees ?? [];

        // Apply filtering if a search query is provided
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $employees = array_filter($employees, function ($employee) use ($search) {
                // Determine the name to search on
                $nameParts = [];
                if (!empty($employee['first_name'])) $nameParts[] = $employee['first_name'];
                if (!empty($employee['last_name'])) $nameParts[] = $employee['last_name'];
                $firstNameLastName = implode(' ', $nameParts);
                $name = !empty($employee['name']) ? $employee['name'] : $firstNameLastName;

                $position = $employee['position_name'] ?? $employee['position'] ?? '';

                $nameMatch = str_contains(strtolower($name), $search);
                $positionMatch = str_contains(strtolower($position), $search);
                
                return $nameMatch || $positionMatch;
            });
        }

        return view('offices.show', compact('employees', 'uuid'));
    }

    public function getEmployeeCount($uuid)
    {
        $token = session('ihri_token');
        
        if (!$token) {
            return response()->json(['count' => 0, 'employees' => []]);
        }

        $employees = $this->ihriService->getEmployeesByOffice($uuid, $token);
        $employees = $employees['data'] ?? $employees ?? [];

        // Normalize employee data
        $normalized = array_map(function($emp) {
            $nameParts = [];
            if (!empty($emp['first_name'])) $nameParts[] = $emp['first_name'];
            if (!empty($emp['last_name'])) $nameParts[] = $emp['last_name'];
            $fullName = !empty($emp['name']) ? $emp['name'] : implode(' ', $nameParts);

            return [
                'name' => $fullName ?: 'Unknown',
                'email' => $emp['email'] ?? 'No Email Provided',
                'position' => $emp['position_name'] ?? $emp['position'] ?? 'No Position',
                'employment_status' => $emp['employment_status'] ?? 'Permanent',
            ];
        }, $employees);

        return response()->json(['count' => count($employees), 'employees' => $normalized]);
    }
}
