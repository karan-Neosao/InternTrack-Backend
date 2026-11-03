<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\Application;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'active_students' => User::where('role', 'student')->where('is_active', true)->count(),
            'total_companies' => User::where('role', 'company')->count(),
            'verified_companies' => User::where('role', 'company')->whereHas('companyProfile', function ($q) {
                $q->where('is_verified', true);
            })->count(),
            'total_internships' => Internship::count(),
            'active_internships' => Internship::where('status', 'active')->count(),
            'closed_internships' => Internship::where('status', 'closed')->count(),
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'reviewed_applications' => Application::where('status', 'reviewed')->count(),
            'accepted_applications' => Application::where('status', 'accepted')->count(),
            'rejected_applications' => Application::where('status', 'rejected')->count(),
            'total_categories' => Category::count(),
        ];

        // Recent applications with eager loaded relations
        $recentApplications = Application::with([
            'student:id,name,email',
            'internship:id,title,company_id',
            'internship.company:id,name',
        ])->latest()->take(6)->get();

        // Recent students
        $recentStudents = User::where('role', 'student')
            ->with('studentProfile')
            ->latest()
            ->take(5)
            ->get();

        // Recent companies
        $recentCompanies = User::where('role', 'company')
            ->with('companyProfile')
            ->latest()
            ->take(5)
            ->get();

        // Latest internships
        $latestInternships = Internship::with(['company:id,name', 'category:id,name'])
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        // Monthly trends for past 6 months for Chart.js
        $monthlyLabels = [];
        $monthlyStudents = [];
        $monthlyCompanies = [];
        $monthlyApplications = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();

            $monthlyLabels[] = $monthStart->format('M Y');
            $monthlyStudents[] = User::where('role', 'student')->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $monthlyCompanies[] = User::where('role', 'company')->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $monthlyApplications[] = Application::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentApplications',
            'recentStudents',
            'recentCompanies',
            'latestInternships',
            'monthlyLabels',
            'monthlyStudents',
            'monthlyCompanies',
            'monthlyApplications'
        ));
    }
}