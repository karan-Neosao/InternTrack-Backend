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

        // Top Companies by internship count
        $topCompanies = User::where('role', 'company')
            ->with('companyProfile')
            ->withCount('internships')
            ->orderByDesc('internships_count')
            ->take(3)
            ->get();

        // Recent activity stream
        $recentActivities = collect();

        foreach ($recentStudents->take(2) as $s) {
            $recentActivities->push([
                'type' => 'student',
                'title' => 'New student registered',
                'subtitle' => $s->name,
                'created_at' => $s->created_at,
                'icon' => 'bi-person-fill',
                'color' => '#2563EB',
                'bg' => '#EFF6FF',
            ]);
        }

        foreach ($recentCompanies->take(2) as $c) {
            $recentActivities->push([
                'type' => 'company',
                'title' => 'New company added',
                'subtitle' => $c->name,
                'created_at' => $c->created_at,
                'icon' => 'bi-buildings-fill',
                'color' => '#10B981',
                'bg' => '#ECFDF5',
            ]);
        }

        foreach ($recentApplications->take(2) as $a) {
            $recentActivities->push([
                'type' => 'application',
                'title' => 'New application received',
                'subtitle' => $a->student->name ?? 'Candidate',
                'created_at' => $a->created_at,
                'icon' => 'bi-file-earmark-text-fill',
                'color' => '#8B5CF6',
                'bg' => '#F5F3FF',
            ]);
        }

        foreach ($latestInternships->take(2) as $in) {
            $recentActivities->push([
                'type' => 'internship',
                'title' => 'Internship updated',
                'subtitle' => $in->title,
                'created_at' => $in->updated_at ?? $in->created_at,
                'icon' => 'bi-briefcase-fill',
                'color' => '#F97316',
                'bg' => '#FFF7ED',
            ]);
        }

        $recentActivities = $recentActivities->sortByDesc('created_at')->take(4)->values();

        return view('admin.dashboard', compact(
            'stats',
            'recentApplications',
            'recentStudents',
            'recentCompanies',
            'latestInternships',
            'topCompanies',
            'recentActivities',
            'monthlyLabels',
            'monthlyStudents',
            'monthlyCompanies',
            'monthlyApplications'
        ));
    }
}