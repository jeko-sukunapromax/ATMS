<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SyncIHRIJob implements ShouldQueue
{
    use Queueable;

    protected $token;

    /**
     * Create a new job instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('SyncIHRIJob started for token: ' . substr($this->token, 0, 10) . '...');
        
        try {
            Artisan::call('ihri:sync', [
                '--token' => $this->token,
            ]);
            Log::info('SyncIHRIJob finished successfully.');
        } catch (\Exception $e) {
            Log::error('SyncIHRIJob failed: ' . $e->getMessage());
        }
    }
}
