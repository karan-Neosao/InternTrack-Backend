<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\InternshipController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    return redirect('/admin/login');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Auth Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Authenticated Admin Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Students Management
        Route::get('/students', [StudentController::class, 'index'])->name('students');
        Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
        Route::post('/students/{id}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');
        Route::get('/students/{id}/resume', [StudentController::class, 'downloadResume'])->name('students.resume');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        // Companies Management
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
        Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
        Route::post('/companies/{id}/toggle-verify', [CompanyController::class, 'toggleVerify'])->name('companies.toggle-verify');
        Route::post('/companies/{id}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

        // Internships Management
        Route::get('/internships', [InternshipController::class, 'index'])->name('internships');
        Route::get('/internships/create', [InternshipController::class, 'create'])->name('internships.create');
        Route::post('/internships', [InternshipController::class, 'store'])->name('internships.store');
        Route::get('/internships/{id}', [InternshipController::class, 'show'])->name('internships.show');
        Route::get('/internships/{id}/edit', [InternshipController::class, 'edit'])->name('internships.edit');
        Route::put('/internships/{id}', [InternshipController::class, 'update'])->name('internships.update');
        Route::post('/internships/{id}/toggle-status', [InternshipController::class, 'toggleStatus'])->name('internships.toggle-status');
        Route::delete('/internships/{id}', [InternshipController::class, 'destroy'])->name('internships.destroy');

        // Applications Management
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
        Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
        Route::patch('/applications/{id}/update-status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
        Route::get('/applications/{id}/resume', [ApplicationController::class, 'downloadResume'])->name('applications.resume');
        Route::delete('/applications/{id}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

        // Categories Management
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Notifications Management
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

        // Reports & Analytics
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/export/{type}', [ReportController::class, 'exportCsv'])->name('reports.export');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::put('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile');
        Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password');
    });
});
