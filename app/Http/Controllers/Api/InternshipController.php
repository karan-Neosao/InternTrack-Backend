<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    // View all active internships
    public function index(Request $request)
    {
        $query = Internship::with([
            'company:id,name',
            'company.companyProfile',
            'category:id,name,slug'
        ])
            ->where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('skills', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->input('work_type'));
        }

        $internships = $query->latest()->paginate($request->input('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $internships,
        ], 200);
    }

    // View single internship
    public function show($id)
    {
        $internship = Internship::with([
            'company:id,name',
            'company.companyProfile',
            'category:id,name,slug'
        ])
            ->where('status', 'active')
            ->find($id);

        if (!$internship) {
            return response()->json([
                'success' => false,
                'message' => 'Internship not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $internship,
        ], 200);
    }

    // Company creates internship
    public function store(Request $request)
    {
        if ($request->user()->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only companies can post internships',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skills' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'stipend' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $internship = Internship::create([
            ...$validated,
            'company_id' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Internship created successfully',
            'data' => $internship,
        ], 201);
    }

    // Company updates its own internship
    public function update(Request $request, $id)
    {
        $internship = Internship::find($id);

        if (!$internship) {
            return response()->json([
                'success' => false,
                'message' => 'Internship not found',
            ], 404);
        }

        if (
            $request->user()->role !== 'company' ||
            $internship->company_id !== $request->user()->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot update this internship',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'skills' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'work_type' => 'sometimes|required|in:remote,onsite,hybrid',
            'stipend' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'deadline' => 'nullable|date|after_or_equal:today',
            'status' => 'sometimes|required|in:active,closed',
        ]);

        $internship->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Internship updated successfully',
            'data' => $internship,
        ], 200);
    }

    // Company deletes its own internship
    public function destroy(Request $request, $id)
    {
        $internship = Internship::find($id);

        if (!$internship) {
            return response()->json([
                'success' => false,
                'message' => 'Internship not found',
            ], 404);
        }

        if (
            $request->user()->role !== 'company' ||
            $internship->company_id !== $request->user()->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete this internship',
            ], 403);
        }

        $internship->delete();

        return response()->json([
            'success' => true,
            'message' => 'Internship deleted successfully',
        ], 200);
    }
}
