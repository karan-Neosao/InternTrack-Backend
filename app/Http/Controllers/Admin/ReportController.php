<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Overall statistics
        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'period_students' => User::where('role', 'student')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_companies' => User::where('role', 'company')->count(),
            'period_companies' => User::where('role', 'company')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_internships' => Internship::count(),
            'active_internships' => Internship::where('status', 'active')->count(),
            'closed_internships' => Internship::where('status', 'closed')->count(),
            'total_applications' => Application::count(),
            'period_applications' => Application::whereBetween('created_at', [$startDate, $endDate])->count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'accepted_applications' => Application::where('status', 'accepted')->count(),
            'rejected_applications' => Application::where('status', 'rejected')->count(),
            'reviewed_applications' => Application::where('status', 'reviewed')->count(),
        ];

        // Monthly breakdown for the past 6 months
        $months = [];
        $studentRegistrations = [];
        $companyRegistrations = [];
        $applicationsSubmitted = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            $monthLabel = $monthStart->format('M Y');

            $months[] = $monthLabel;
            $studentRegistrations[] = User::where('role', 'student')->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $companyRegistrations[] = User::where('role', 'company')->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $applicationsSubmitted[] = Application::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        // Recent activity summaries
        $topInternships = Internship::with('company:id,name')
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'startDate',
            'endDate',
            'months',
            'studentRegistrations',
            'companyRegistrations',
            'applicationsSubmitted',
            'topInternships'
        ));
    }

    public function exportCsv(Request $request, string $type)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        $filename = "interntrack-{$type}-report-" . date('Y-m-d-His') . ".csv";

        return new StreamedResponse(function () use ($type) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            if ($type === 'students') {
                fputcsv($handle, ['ID', 'Name', 'Email', 'Status', 'Phone', 'College', 'Course', 'Graduation Year', 'Skills', 'LinkedIn', 'Registered At']);

                User::where('role', 'student')
                    ->with('studentProfile')
                    ->chunk(100, function ($students) use ($handle) {
                        foreach ($students as $student) {
                            fputcsv($handle, [
                                $student->id,
                                $student->name,
                                $student->email,
                                $student->is_active ? 'Active' : 'Inactive',
                                $student->studentProfile?->phone ?? 'N/A',
                                $student->studentProfile?->college ?? 'N/A',
                                $student->studentProfile?->course ?? 'N/A',
                                $student->studentProfile?->graduation_year ?? 'N/A',
                                $student->studentProfile?->skills ?? 'N/A',
                                $student->studentProfile?->linkedin_url ?? 'N/A',
                                $student->created_at->format('Y-m-d H:i:s'),
                            ]);
                        }
                    });
            } elseif ($type === 'companies') {
                fputcsv($handle, ['ID', 'Name', 'Email', 'Company Name', 'Industry', 'Location', 'Website', 'Verified', 'Status', 'Registered At']);

                User::where('role', 'company')
                    ->with('companyProfile')
                    ->chunk(100, function ($companies) use ($handle) {
                        foreach ($companies as $company) {
                            fputcsv($handle, [
                                $company->id,
                                $company->name,
                                $company->email,
                                $company->companyProfile?->company_name ?? $company->name,
                                $company->companyProfile?->industry ?? 'N/A',
                                $company->companyProfile?->location ?? 'N/A',
                                $company->companyProfile?->website ?? 'N/A',
                                $company->companyProfile?->is_verified ? 'Yes' : 'No',
                                $company->is_active ? 'Active' : 'Inactive',
                                $company->created_at->format('Y-m-d H:i:s'),
                            ]);
                        }
                    });
            } elseif ($type === 'internships') {
                fputcsv($handle, ['ID', 'Title', 'Company', 'Category', 'Work Type', 'Location', 'Stipend', 'Duration', 'Deadline', 'Status', 'Applications Count', 'Created At']);

                Internship::with(['company:id,name', 'category:id,name'])
                    ->withCount('applications')
                    ->chunk(100, function ($internships) use ($handle) {
                        foreach ($internships as $item) {
                            fputcsv($handle, [
                                $item->id,
                                $item->title,
                                $item->company?->name ?? 'N/A',
                                $item->category?->name ?? 'Uncategorized',
                                ucfirst($item->work_type),
                                $item->location ?? 'N/A',
                                $item->stipend > 0 ? '$' . number_format($item->stipend, 2) : 'Unpaid',
                                $item->duration ?? 'N/A',
                                $item->deadline ? $item->deadline->format('Y-m-d') : 'No deadline',
                                ucfirst($item->status),
                                $item->applications_count,
                                $item->created_at->format('Y-m-d H:i:s'),
                            ]);
                        }
                    });
            } elseif ($type === 'applications') {
                fputcsv($handle, ['ID', 'Student Name', 'Student Email', 'Internship Title', 'Company Name', 'Status', 'Applied At']);

                Application::with(['student:id,name,email', 'internship.company:id,name'])
                    ->chunk(100, function ($applications) use ($handle) {
                        foreach ($applications as $app) {
                            fputcsv($handle, [
                                $app->id,
                                $app->student?->name ?? 'N/A',
                                $app->student?->email ?? 'N/A',
                                $app->internship?->title ?? 'N/A',
                                $app->internship?->company?->name ?? 'N/A',
                                ucfirst($app->status),
                                $app->applied_at ? Carbon::parse($app->applied_at)->format('Y-m-d H:i:s') : $app->created_at->format('Y-m-d H:i:s'),
                            ]);
                        }
                    });
            }

            fclose($handle);
        }, 200, array_merge($headers, [
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]));
    }
}
