<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $companyId = $request->input('company_id');

        $applications = Application::with([
            'student.studentProfile',
            'internship.company.companyProfile',
        ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('internship', function ($internshipQuery) use ($search) {
                        $internshipQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($companyId, function ($query, $companyId) {
                $query->whereHas('internship', function ($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $companies = User::where('role', 'company')->orderBy('name')->get();

        $metrics = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'reviewed' => Application::where('status', 'reviewed')->count(),
            'accepted' => Application::where('status', 'accepted')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'search', 'status', 'companyId', 'companies', 'metrics'));
    }

    public function show($id)
    {
        $application = Application::with([
            'student.studentProfile',
            'internship.company.companyProfile',
        ])->findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
        ]);

        $application->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', "Application status has been updated to '" . ucfirst($validated['status']) . "'.");
    }

    public function downloadResume($id)
    {
        $application = Application::with('student.studentProfile')->findOrFail($id);

        // Check if application has a resume_path, otherwise fall back to student's profile resume
        $path = $application->resume_path ?? $application->student->studentProfile?->resume_path;

        if (!$path) {
            return back()->with('error', 'No resume attached to this application or student profile.');
        }

        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error', 'Resume file not found in storage.');
        }

        return Storage::disk('public')->download($path, "application_{$application->id}_resume." . pathinfo($path, PATHINFO_EXTENSION));
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);

        if ($application->resume_path) {
            Storage::disk('public')->delete($application->resume_path);
        }

        $application->delete();

        return redirect()
            ->route('admin.applications')
            ->with('success', 'Application deleted successfully.');
    }
}
