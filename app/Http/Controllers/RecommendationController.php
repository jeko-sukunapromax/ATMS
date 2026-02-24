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
        abort_if($finding->audit_id !== $audit->id, 404);

        if ($audit->status === 'completed') {
            return redirect()->route('audit-projects.show', $audit->id)
                ->with('error', 'Cannot add recommendations to a completed audit.');
        }

        $validatedData = $request->validate([
            'description' => 'required|string|max:1000',
            'due_date' => 'nullable|date',
        ]);

        $recommendation = new Recommendation();
        $recommendation->finding_id = $finding->id;
        $recommendation->description = $validatedData['description'];
        $recommendation->due_date = $validatedData['due_date'] ?? null;
        $recommendation->status = 'pending';
        $recommendation->save();

        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Recommendation added successfully.');
    }

    public function destroy(Audit $audit, Finding $finding, Recommendation $recommendation)
    {
        abort_if($finding->audit_id !== $audit->id, 404);
        abort_if($recommendation->finding_id !== $finding->id, 404);

        if ($audit->status === 'completed') {
            return redirect()->route('audit-projects.show', $audit->id)
                ->with('error', 'Cannot delete recommendations of a completed audit.');
        }

        $recommendation->delete();
        return redirect()->route('audit-projects.show', $audit->id)
            ->with('success', 'Recommendation removed.');
    }
}
