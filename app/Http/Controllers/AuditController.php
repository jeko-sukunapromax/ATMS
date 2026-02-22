<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Services\IHRIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    protected $ihriService;

    public function __construct(IHRIService $ihriService)
    {
        $this->ihriService = $ihriService;
    }

    public function index()
    {
        $audits = Audit::with('auditor')->latest()->paginate(10);
        return view('audits.index', compact('audits'));
    }

    public function create()
    {
        $token = session('ihri_token');
        $offices = [];

        if ($token) {
            $response = $this->ihriService->getOffices($token);
            $offices = $response['data'] ?? $response ?? [];
        }

        return view('audits.create-audit', compact('offices'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'office_uuid' => 'required|uuid',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $audit = new Audit($validatedData);
        $audit->auditor_id = Auth::id();
        $audit->status = 'pending';
        $audit->save();

        return redirect()->route('audit-projects.index')->with('success', 'Audit project created successfully.');
    }

    public function show(Audit $audit)
    {
        $audit->load(['findings.recommendations', 'auditor']);
        
        $token = session('ihri_token');
        $officeName = 'Unknown Office';
        $response = $this->ihriService->getOffices($token);
        $offices = $response['data'] ?? $response ?? [];
        foreach ($offices as $office) {
            if (($office['uuid'] ?? '') == $audit->office_uuid) {
                $officeName = $office['name'] ?? 'Unknown Office';
                break;
            }
        }

        return view('audits.audit-details', compact('audit', 'officeName'));
    }

    public function edit(Audit $audit)
    {
        $token = session('ihri_token');
        $response = $this->ihriService->getOffices($token);
        $offices = $response['data'] ?? $response ?? [];

        return view('audits.edit-audit', compact('audit', 'offices'));
    }

    public function update(Request $request, Audit $audit)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'office_uuid' => 'required|uuid',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,ongoing,completed',
        ]);

        if ($validatedData['status'] === 'completed') {
            $hasOpenRisks = $audit->findings()->where('status', 'open')->exists();
            
            if ($hasOpenRisks) {
                return redirect()->back()->withInput()->withErrors(['status' => 'Cannot mark this audit as completed while there are still OPEN findings. Please resolve or close all findings first.']);
            }
        }

        $audit->update($validatedData);

        return redirect()->route('audit-projects.index')->with('success', 'Audit project updated successfully.');
    }

    public function destroy(Audit $audit)
    {
        $audit->delete();
        return redirect()->route('audit-projects.index')->with('success', 'Audit project deleted successfully.');
    }
}
