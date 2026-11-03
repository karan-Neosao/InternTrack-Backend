<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Check admin role
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access dashboard',
            ], 403);
        }

        $statistics = [
            'total_students' => User::where('role', 'student')->count(),

            'total_companies' => User::where('role', 'company')->count(),

            'total_internships' => Internship::count(),

            'active_internships' => Internship::where('status', 'active')->count(),

            'total_applications' => Application::count(),

            'pending_applications' => Application::where('status', 'pending')->count(),

            'accepted_applications' => Application::where('status', 'accepted')->count(),

            'rejected_applications' => Application::where('status', 'rejected')->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Admin dashboard statistics',
            'data' => $statistics,
        ], 200);
    }
    public function students(Request $request)
{
    if ($request->user()->role !== 'admin') {
        return response()->json([
            'success' => false,
            'message' => 'Only admin can view students',
        ], 403);
    }

    $students = User::where('role', 'student')
        ->with('studentProfile')
        ->latest()
        ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Students fetched successfully',
        'data' => $students,
    ], 200);
}
public function companies(Request $request)
{
    if ($request->user()->role !== 'admin') {
        return response()->json([
            'success' => false,
            'message' => 'Only admin can view companies',
        ], 403);
    }

    $companies = User::where('role', 'company')
        ->with('companyProfile')
        ->latest()
        ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Companies fetched successfully',
        'data' => $companies,
    ], 200);
}
}
