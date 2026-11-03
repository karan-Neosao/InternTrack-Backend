<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $workType = $request->input('work_type');
        $status = $request->input('status');
        $categoryId = $request->input('category_id');
        $location = $request->input('location');

        $internships = Internship::with(['company:id,name', 'category:id,name'])
            ->withCount('applications')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('skills', 'like', "%{$search}%")
                        ->orWhereHas('company', function ($companyQuery) use ($search) {
                            $companyQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($workType, function ($query, $workType) {
                $query->where('work_type', $workType);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($location, function ($query, $location) {
                $query->where('location', 'like', "%{$location}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $metrics = [
            'total' => Internship::count(),
            'active' => Internship::where('status', 'active')->count(),
            'remote' => Internship::where('work_type', 'remote')->count(),
            'total_applications' => \App\Models\Application::count(),
        ];

        return view('admin.internships.index', compact('internships', 'search', 'workType', 'status', 'categoryId', 'location', 'categories', 'metrics'));
    }

    public function create()
    {
        $companies = User::where('role', 'company')->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.internships.create', compact('companies', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:users,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'skills' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'work_type' => ['required', 'in:remote,onsite,hybrid'],
            'stipend' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:active,closed'],
        ]);

        $internship = Internship::create($validated);

        return redirect()
            ->route('admin.internships')
            ->with('success', "Internship '{$internship->title}' created successfully.");
    }

    public function show($id)
    {
        $internship = Internship::with([
            'company.companyProfile',
            'category',
            'applications.student.studentProfile',
        ])->findOrFail($id);

        return view('admin.internships.show', compact('internship'));
    }

    public function edit($id)
    {
        $internship = Internship::findOrFail($id);
        $companies = User::where('role', 'company')->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.internships.edit', compact('internship', 'companies', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        $validated = $request->validate([
            'company_id' => ['required', 'exists:users,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'skills' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'work_type' => ['required', 'in:remote,onsite,hybrid'],
            'stipend' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:active,closed'],
        ]);

        $internship->update($validated);

        return redirect()
            ->route('admin.internships.show', $internship->id)
            ->with('success', "Internship updated successfully.");
    }

    public function toggleStatus($id)
    {
        $internship = Internship::findOrFail($id);
        $internship->status = ($internship->status === 'active') ? 'closed' : 'active';
        $internship->save();

        return back()->with('success', "Internship status changed to {$internship->status}.");
    }

    public function destroy($id)
    {
        $internship = Internship::findOrFail($id);
        $title = $internship->title;

        $internship->applications()->delete();
        $internship->delete();

        return redirect()
            ->route('admin.internships')
            ->with('success', "Internship '{$title}' and its applications have been deleted.");
    }
}
