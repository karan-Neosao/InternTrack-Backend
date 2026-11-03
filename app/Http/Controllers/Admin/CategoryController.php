<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $categories = Category::withCount('internships')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status === 'active' || $status === '1');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $metrics = [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'total_internships' => \App\Models\Internship::count(),
            'uncategorized' => \App\Models\Internship::whereNull('category_id')->count(),
        ];

        return view('admin.categories.index', compact('categories', 'search', 'status', 'metrics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category updated successfully.');
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        $statusText = $category->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Category '{$category->name}' has been {$statusText}.");
    }

    public function destroy($id)
    {
        $category = Category::withCount('internships')->findOrFail($id);

        if ($category->internships_count > 0) {
            return back()->with('error', "Cannot delete category '{$category->name}' because {$category->internships_count} internships are linked to it.");
        }

        $category->delete();

        return redirect()
            ->route('admin.categories')
            ->with('success', "Category '{$category->name}' has been deleted successfully.");
    }
}
