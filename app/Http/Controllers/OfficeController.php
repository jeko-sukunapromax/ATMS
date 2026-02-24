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
        $offices = [];

        if (true) { // Try to fetch even if token is missing
            $response = $this->ihriService->getOffices($token);
            $offices = $response['data'] ?? $response ?? [];
        }

        // Apply filtering if a search query is provided
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $offices = array_filter($offices, function ($office) use ($search) {
                // Check if name or acronym contains the search term
                $nameMatch = isset($office['name']) && str_contains(strtolower($office['name']), $search);
                $acronymMatch = isset($office['acronym']) && str_contains(strtolower($office['acronym']), $search);
                
                return $nameMatch || $acronymMatch;
            });
        }

        return view('offices.index', compact('offices'));
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
            return response()->json(['count' => 0]);
        }

        $employees = $this->ihriService->getEmployeesByOffice($uuid, $token);
        $employees = $employees['data'] ?? $employees ?? [];

        return response()->json(['count' => count($employees)]);
    }
}
