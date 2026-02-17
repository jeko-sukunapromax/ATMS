<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IHRIService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ihri.url');
    }

    /**
     * Authenticate with iHRI API
     */
    public function login(string $email, string $password)
    {
        try {
            $response = Http::withoutVerifying()->post("{$this->baseUrl}/login", [
                'email' => $email,
                'password' => $password,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error("iHRI Login Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all employees in a specific office
     */
    public function getEmployeesByOffice(string $officeUuid, string $token)
    {
        try {
            $response = Http::withoutVerifying()->withToken($token)
                ->get("{$this->baseUrl}/all-employees/office/{$officeUuid}");

            return $response->json();
        } catch (\Exception $e) {
            Log::error("iHRI Get Employees Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get permanent users
     */
    public function getUsers(string $token)
    {
        try {
            $response = Http::withoutVerifying()->withToken($token)
                ->get("{$this->baseUrl}/users");

            return $response->json();
        } catch (\Exception $e) {
            Log::error("iHRI Get Users Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all offices
     */
    public function getOffices(?string $token = null)
    {
        try {
            $request = Http::withoutVerifying();
            
            if ($token) {
                $request->withToken($token);
            }

            $response = $request->get("{$this->baseUrl}/offices");

            return $response->json();
        } catch (\Exception $e) {
            Log::error("iHRI Get Offices Error: " . $e->getMessage());
            return null;
        }
    }
}
