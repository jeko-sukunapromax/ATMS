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
    public function index()
    {
        // dd('DEBUG: HIT USER CONTROLLER');
        $token = session('ihri_token');
        
        if (!$token) {
            session()->flash('warning', 'iHRI Token is missing. Please logout and login again using your iHRI credentials to access the live directory.');
        } else {
            $response = $this->ihriService->getUsers($token);
            $permanentUsers = $response['data'] ?? $response ?? [];
        }

        return view('users.user-management', compact('permanentUsers'));
    }
}
