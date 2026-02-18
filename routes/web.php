<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('offices', \App\Http\Controllers\OfficeController::class)->only(['index', 'show']);
    
    // Audit Tracking Routes (kebab-case)
    Route::resource('audit-projects', \App\Http\Controllers\AuditController::class)->parameters([
        'audit-projects' => 'audit'
    ]);
    
    // Finding Routes (kebab-case routes, camelCase methods)
    Route::get('audit-projects/{audit}/add-finding', [\App\Http\Controllers\FindingController::class, 'createFinding'])->name('findings.create');
    Route::post('audit-projects/{audit}/store-finding', [\App\Http\Controllers\FindingController::class, 'storeFinding'])->name('findings.store');
    Route::get('audit-projects/{audit}/findings/{finding}/edit', [\App\Http\Controllers\FindingController::class, 'editFinding'])->name('findings.edit');
    Route::put('audit-projects/{audit}/findings/{finding}', [\App\Http\Controllers\FindingController::class, 'updateFinding'])->name('findings.update');
    Route::delete('audit-projects/{audit}/findings/{finding}', [\App\Http\Controllers\FindingController::class, 'destroyFinding'])->name('findings.destroy');

    // Recommendation Routes
    Route::post('audit-projects/{audit}/findings/{finding}/recommendations', [\App\Http\Controllers\RecommendationController::class, 'store'])->name('recommendations.store');
    Route::delete('audit-projects/{audit}/findings/{finding}/recommendations/{recommendation}', [\App\Http\Controllers\RecommendationController::class, 'destroy'])->name('recommendations.destroy');


    // User Management Routes
    Route::get('user-management', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('user-management/sync', [\App\Http\Controllers\UserController::class, 'sync'])->name('users.sync');
    Route::get('user-management/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('user-management/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('user-management/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
});
