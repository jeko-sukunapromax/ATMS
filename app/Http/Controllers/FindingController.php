<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Finding;
use Illuminate\Http\Request;

class FindingController extends Controller
{
    /**
     * Show the form for creating a new finding.
     */
    public function createFinding(Audit $audit)
    {
        return view('findings.create-finding', compact('audit'));
    }

    /**
     * Store a newly created finding in storage.
     */
    public function storeFinding(Request $request, Audit $audit)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:low,medium,high',
            'status' => 'required|in:open,resolved,closed',
        ]);

        $finding = new Finding();
        $finding->audit_id = $audit->id;
        $finding->title = $validatedData['title'];
        $finding->description = $validatedData['description'];
        $finding->risk_level = $validatedData['riskLevel'];
        $finding->status = $validatedData['status'];
        $finding->save();
        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Finding added successfully.');
    }

    public function editFinding(Audit $audit, Finding $finding)
    {
        return view('findings.edit-finding', compact('audit', 'finding'));
    }

    public function updateFinding(Request $request, Audit $audit, Finding $finding)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:low,medium,high',
            'status' => 'required|in:open,resolved,closed',
        ]);

        $finding->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'risk_level' => $validatedData['riskLevel'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Finding updated successfully.');
    }

    public function destroyFinding(Audit $audit, Finding $finding)
    {
        $finding->delete();
        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Finding deleted successfully.');
    }
}
