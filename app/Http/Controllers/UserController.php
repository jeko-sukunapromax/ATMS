<?php

namespace App\Http\Controllers;

use App\Services\IHRIService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $ihriService;

    public function __construct(IHRIService $ihriService)
    {
        $this->ihriService = $ihriService;
    }

    /**
     * Display a listing of permanent users from iHRI.
     */
    public function index(Request $request)
    {
        $token = session('ihri_token');
        
        if (!$token) {
            session()->flash('warning', 'iHRI Token is missing. Please logout and login again using your iHRI credentials to ensure your directory is fully synced.');
        }

        $query = \App\Models\User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->input('position'));
        }

        // Filter by office
        if ($request->filled('office')) {
            $query->where('office', $request->input('office'));
        }

        $permanentUsers = $query->orderBy('name')->paginate(10)->withQueryString();

        // Get unique positions and offices for dropdowns
        $positions = \App\Models\User::whereNotNull('position')->distinct()->pluck('position');
        $offices = \App\Models\User::whereNotNull('office')->distinct()->pluck('office');

        return view('users.user-management', compact('permanentUsers', 'positions', 'offices'));
    }
    public function sync()
    {
        $token = session('ihri_token');

        if (!$token) {
            return redirect()->back()->with('warning', 'Token expired. Please login again.');
        }

        \App\Jobs\SyncIHRIJob::dispatch($token);

        return redirect()->back()->with('success', 'Syncing process started in the background (32 offices). This may take 2-5 minutes. You can refresh this page later to see the updated list.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(\App\Models\User $user)
    {
        // Get all roles to display in the dropdown
        $roles = \Spatie\Permission\Models\Role::pluck('name', 'name');
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Sync local role
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User role updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(\App\Models\User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User removed successfully.');
    }
}
