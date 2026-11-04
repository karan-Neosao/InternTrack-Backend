<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $students = User::where('role', 'student')
            ->with('studentProfile')
            ->withCount('applications')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('studentProfile', function ($profileQuery) use ($search) {
                          $profileQuery->where('college', 'like', "%{$search}%")
                              ->orWhere('course', 'like', "%{$search}%")
                              ->orWhere('phone', 'like', "%{$search}%")
                              ->orWhere('skills', 'like', "%{$search}%");
                      });
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status === 'active' || $status === '1');
            })
            ->when($request->filled('has_resume'), function ($query) {
                $query->whereHas('studentProfile', function ($profileQuery) {
                    $profileQuery->whereNotNull('resume_path')->where('resume_path', '!=', '');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $metrics = [
            'total' => User::where('role', 'student')->count(),
            'active' => User::where('role', 'student')->where('is_active', true)->count(),
            'with_resume' => DB::table('student_profiles')->whereNotNull('resume_path')->where('resume_path', '!=', '')->count(),
            'with_applications' => Application::distinct('student_id')->count('student_id'),
        ];

        return view('admin.students.index', compact('students', 'search', 'status', 'metrics'));
    }

    public function show($id)
    {
        $student = User::where('role', 'student')
            ->with(['studentProfile', 'applications.internship.company'])
            ->findOrFail($id);

        return view('admin.students.show', compact('student'));
    }

    public function toggleStatus($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->is_active = !$student->is_active;
        $student->save();

        $statusText = $student->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Student '{$student->name}' has been {$statusText} successfully.");
    }

    public function downloadResume($id)
    {
        $student = User::where('role', 'student')->with('studentProfile')->findOrFail($id);

        if (!$student->studentProfile || !$student->studentProfile->resume_path) {
            return back()->with('error', 'No resume uploaded for this student.');
        }

        $path = $student->studentProfile->resume_path;

        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error', 'Resume file not found in storage.');
        }

        return Storage::disk('public')->download($path, "resume_{$student->id}_" . basename($path));
    }

    public function destroy($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $hasApplications = Application::where('student_id', $student->id)->exists();

        try {
            DB::transaction(function () use ($student) {
                // Remove resume if exists
                if ($student->studentProfile && $student->studentProfile->resume_path) {
                    Storage::disk('public')->delete($student->studentProfile->resume_path);
                }

                // Delete profile and user
                $student->studentProfile()?->delete();
                $student->applications()?->delete();
                $student->tokens()->delete();
                $student->delete();
            });

            return redirect()
                ->route('admin.students')
                ->with('success', "Student '{$student->name}' and all associated records have been safely deleted.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }
}