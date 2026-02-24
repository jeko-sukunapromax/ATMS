<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Finding;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $ihriService;

    public function __construct(\App\Services\IHRIService $ihriService)
    {
        $this->ihriService = $ihriService;
    }

    public function index()
    {
        $token = session('ihri_token');
        
        // Get generic stats
        $usersCount = User::count();
        $auditsCount = Audit::count();
        $findingsCount = Finding::count();

        // Data for Chart (Audits by Status)
        $pendingAudits = Audit::where('status', 'pending')->count();
        $ongoingAudits = Audit::where('status', 'ongoing')->count();
        $completedAudits = Audit::where('status', 'completed')->count();

        $chartData = [
            'labels' => ['Pending', 'Ongoing', 'Completed'],
            'data' => [$pendingAudits, $ongoingAudits, $completedAudits]
        ];

        // Recent Audit Projects (Latest 5)
        $recentAudits = Audit::orderBy('created_at', 'desc')->take(5)->get();

        // High Risk Findings Alerts (Latest 5 that are open)
        $highRiskFindings = Finding::with('audit')
            ->where('risk_level', 'high')
            ->where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $response = $this->ihriService->getOffices($token);
        $offices = $response['data'] ?? $response ?? [];
        $officeMap = [];
        foreach ($offices as $office) {
            if (isset($office['uuid'])) {
                $officeMap[$office['uuid']] = $office['name'] ?? 'Unknown';
            }
        }

        return view('dashboard', compact('usersCount', 'auditsCount', 'findingsCount', 'chartData', 'recentAudits', 'highRiskFindings', 'officeMap'));
    }
}
