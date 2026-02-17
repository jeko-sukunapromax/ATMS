<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Finding;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function store(Request $request, Audit $audit, Finding $finding)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $recommendation = new Recommendation();
        $recommendation->finding_id = $finding->id;
        $recommendation->description = $validatedData['description'];
        $recommendation->status = 'pending';
        $recommendation->save();

        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Recommendation added successfully.');
    }

    public function destroy(Audit $audit, Finding $finding, Recommendation $recommendation)
    {
        $recommendation->delete();
        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Recommendation removed.');
    }
}
