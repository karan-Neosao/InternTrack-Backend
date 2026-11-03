
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InternshipController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\StudentProfileController;
use App\Http\Controllers\Api\CompanyProfileController;
use App\Http\Controllers\Api\AdminController;

// PUBLIC ROUTES - No authentication required
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-company', [AuthController::class, 'registerCompany']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/internships', [InternshipController::class, 'index']);
Route::get('/internships/{id}', [InternshipController::class, 'show']);
Route::get('/categories', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Category::where('is_active', true)->get(),
    ], 200);
});

// PROTECTED ROUTES - Token required
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/internships', [InternshipController::class, 'store']);
    Route::put('/internships/{id}', [InternshipController::class, 'update']);
    Route::delete('/internships/{id}', [InternshipController::class, 'destroy']);
Route::post('/internships/{id}/apply', [ApplicationController::class, 'apply']);
Route::get('/my-applications', [ApplicationController::class, 'myApplications']);
Route::get('/company/applicants', [ApplicationController::class, 'companyApplicants']);
Route::patch('/company/applications/{id}/status', [ApplicationController::class, 'updateStatus']);

Route::get('/student/profile', [StudentProfileController::class, 'show']);

Route::put('/student/profile', [StudentProfileController::class, 'update']);

Route::post('/student/upload-resume', [StudentProfileController::class, 'uploadResume']);


Route::get('/company/profile', [CompanyProfileController::class, 'show']);

Route::put('/company/profile', [CompanyProfileController::class, 'update']);

Route::post('/company/upload-logo', [CompanyProfileController::class, 'uploadLogo']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

Route::get('/admin/students', [AdminController::class, 'students']);

Route::get('/admin/companies', [AdminController::class, 'companies']);
});
