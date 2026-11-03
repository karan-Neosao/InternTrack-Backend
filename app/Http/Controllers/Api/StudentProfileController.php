<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    // View student profile
    public function show(Request $request)
    {
        if ($request->user()->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Only students can view this profile',
            ], 403);
        }

        $profile = StudentProfile::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $request->user(),
                'profile' => $profile,
            ],
        ], 200);
    }

    // Update student profile
    public function update(Request $request)
    {
        if ($request->user()->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Only students can update this profile',
            ], 403);
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'college' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|min:2000|max:2100',
            'skills' => 'nullable|string',
            'linkedin_url' => 'nullable|url|max:255',
            'resume_path' => 'nullable|string|max:255',
        ]);

        $profile = StudentProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        if (!empty($validated['resume_path'])) {
            Application::where('student_id', $request->user()->id)
                ->whereNull('resume_path')
                ->update(['resume_path' => $validated['resume_path']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Student profile updated successfully',
            'data' => $profile,
        ], 200);
    }

    public function uploadResume(Request $request)
    {
        if ($request->user()->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Only students can upload resumes',
            ], 403);
        }

        // Support multiple common field names from mobile clients
        $fileKey = null;
        if ($request->hasFile('resume')) {
            $fileKey = 'resume';
        } elseif ($request->hasFile('file')) {
            $fileKey = 'file';
        } elseif ($request->hasFile('resume_file')) {
            $fileKey = 'resume_file';
        } elseif ($request->hasFile('document')) {
            $fileKey = 'document';
        }

        if (!$fileKey) {
            return response()->json([
                'success' => false,
                'message' => 'No resume file detected in request. Please upload a file with key "resume" or "file".',
            ], 422);
        }

        $request->validate([
            $fileKey => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $profile = StudentProfile::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        // Delete previous resume if available
        if ($profile->resume_path && Storage::disk('public')->exists($profile->resume_path)) {
            Storage::disk('public')->delete($profile->resume_path);
        }

        // Store new resume
        $path = $request->file($fileKey)->store('resumes', 'public');

        $profile->update([
            'resume_path' => $path,
        ]);

        // Automatically update any past applications of this student that had no resume
        Application::where('student_id', $request->user()->id)
            ->whereNull('resume_path')
            ->update(['resume_path' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Resume uploaded successfully',
            'resume_path' => $path,
            'resume_url' => Storage::disk('public')->url($path),
        ], 200);
    }
}
