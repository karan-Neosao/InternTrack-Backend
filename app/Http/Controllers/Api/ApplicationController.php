<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Internship;
use App\Models\StudentProfile;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function apply(Request $request, $id)
    {
        // Only students can apply
        if ($request->user()->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Only students can apply for internships.',
            ], 403);
        }

        // Check internship exists and is active
        $internship = Internship::where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$internship) {
            return response()->json([
                'success' => false,
                'message' => 'Internship not found or closed.',
            ], 404);
        }

        // Validate request
        $validated = $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'resume_path' => 'nullable|string',
        ]);

        // Prevent duplicate applications
        $alreadyApplied = Application::where('student_id', $request->user()->id)
            ->where('internship_id', $internship->id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this internship.',
            ], 409);
        }

        // Handle resume file or existing resume
        $resumePath = null;
        $uploadedFile = $request->file('resume') ?? $request->file('file') ?? $request->file('resume_file');

        if ($uploadedFile) {
            $resumePath = $uploadedFile->store('resumes', 'public');

            // Also attach to student profile if missing or update
            $profile = StudentProfile::firstOrCreate(['user_id' => $request->user()->id]);
            $profile->update(['resume_path' => $resumePath]);
        } elseif ($request->filled('resume_path')) {
            $resumePath = $request->input('resume_path');
        } else {
            // Fall back to student's profile resume
            $resumePath = $request->user()->studentProfile?->resume_path;
        }

        // Create application
        $application = Application::create([
            'student_id' => $request->user()->id,
            'internship_id' => $internship->id,
            'resume_path' => $resumePath,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Internship application submitted successfully.',
            'data' => $application,
        ], 201);
    }
    public function myApplications(Request $request)
{
    if ($request->user()->role !== 'student') {
        return response()->json([
            'success' => false,
            'message' => 'Only students can view their applications',
        ], 403);
    }

    $applications = Application::with('internship.company')
        ->where('student_id', $request->user()->id)
        ->latest()
        ->paginate(10);

    return response()->json([
        'success' => true,
        'data' => $applications,
    ], 200);
}
public function companyApplicants(Request $request)
{
    if ($request->user()->role !== 'company') {
        return response()->json([
            'success' => false,
            'message' => 'Only companies can view applicants',
        ], 403);
    }

    $applications = Application::with([
        'student:id,name,email',
        'internship:id,title,company_id'
    ])
        ->whereHas('internship', function ($query) use ($request) {
            $query->where('company_id', $request->user()->id);
        })
        ->latest()
        ->paginate(10);

    return response()->json([
        'success' => true,
        'data' => $applications,
    ], 200);
}
public function updateStatus(Request $request, $id)
{
    // Check company role
    if ($request->user()->role !== 'company') {
        return response()->json([
            'success' => false,
            'message' => 'Only companies can update application status',
        ], 403);
    }

    // Validate status
    $validated = $request->validate([
        'status' => 'required|in:accepted,rejected,reviewed',
    ]);

    // Find application belonging to this company's internship
    $application = Application::whereHas('internship', function ($query) use ($request) {
        $query->where('company_id', $request->user()->id);
    })->find($id);

    if (!$application) {
        return response()->json([
            'success' => false,
            'message' => 'Application not found',
        ], 404);
    }

    $application->update([
        'status' => $validated['status'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Application status updated successfully',
        'data' => $application,
    ], 200);
}
}
