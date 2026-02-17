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

    public function index()
    {
        $token = session('ihri_token');
        $offices = [];

        if (true) { // Try to fetch even if token is missing
            $response = $this->ihriService->getOffices($token);
            $offices = $response['data'] ?? $response ?? [];
        }

        return view('offices.index', compact('offices'));
    }

    public function show($uuid)
    {
        $token = session('ihri_token');
        
        if (!$token) {
            return redirect()->route('login');
        }

        $employees = $this->ihriService->getEmployeesByOffice($uuid, $token);
        $employees = $employees['data'] ?? $employees ?? [];

        return view('offices.show', compact('employees', 'uuid'));
    }
}
