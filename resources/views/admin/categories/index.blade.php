@extends('admin.layouts.app')

@section('title', 'Categories Master Directory')

@section('breadcrumb')
    <li class="active-item">Categories Master</li>
@endsection

@section('content')

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Categories & Disciplines</h3>
            <span class="badge bg-purple-subtle text-purple border border-purple border-opacity-25 rounded-pill px-2.5 py-1 small" style="background:#F3E8FF; color:#7E22CE;">
                Domain Taxonomy
            </span>
        </div>
        <p class="text-secondary mb-0 small">
            Define career domains, technical fields, and industries to classify internships and power Flutter app search filters.
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add New Category</span>
        </button>
    </div>
</div>

<!-- 4 Top KPI Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.categories') }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="View All Categories">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Total Categories</span>
                    <div class="fs-4 fw-bold text-dark mt-1">{{ number_format($metrics['total'] ?? $categories->total()) }}</div>
                </div>
                <div class="stat-icon purple" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                All defined industry tracks
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.categories', ['status' => 'active']) }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="Filter Active Categories">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Active Tracks</span>
                    <div class="fs-4 fw-bold text-success mt-1">{{ number_format($metrics['active'] ?? 0) }}</div>
                </div>
                <div class="stat-icon success" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <div class="text-success small mt-2 pt-2 border-top fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-check2"></i> Visible on Flutter app
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.internships') }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="View Internships">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Mapped Openings</span>
                    <div class="fs-4 fw-bold text-primary mt-1">{{ number_format($metrics['total_internships'] ?? 0) }}</div>
                </div>
                <div class="stat-icon primary" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Jobs linked to taxonomy
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.internships') }}" class="card p-3 border-0 shadow-sm h-100 kpi-card" title="View Internships Needing Categorization">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-muted fw-bold text-uppercase small" style="font-size: 0.7rem;">Unclassified</span>
                    <div class="fs-4 fw-bold text-warning mt-1">{{ number_format($metrics['uncategorized'] ?? 0) }}</div>
                </div>
                <div class="stat-icon warning" style="width: 38px; height: 38px; font-size: 1.1rem; background: #FFFBEB; color: #D97706;">
                    <i class="bi bi-question-circle-fill"></i>
                </div>
            </div>
            <div class="text-muted small mt-2 pt-2 border-top" style="font-size: 0.75rem;">
                Jobs needing categorization
            </div>
        </a>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="card p-3 mb-4 shadow-sm border-0">
    <form method="GET" action="{{ route('admin.categories') }}" class="row g-2 align-items-center">

        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search by category name, slug, or description..."
                    value="{{ $search }}"
                >
            </div>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses (Active & Inactive)</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>

        @if($search || ($status !== null && $status !== ''))
            <div class="col-auto">
                <a href="{{ route('admin.categories') }}" class="btn btn-light border text-secondary">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            </div>
        @endif

        <div class="col-auto ms-auto text-muted small">
            Showing <strong>{{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }}</strong> of <strong>{{ $categories->total() }}</strong> categories
        </div>

    </form>
</div>

<!-- Table Card -->
<div class="card shadow-sm border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Category Title</th>
                    <th>URL Slug</th>
                    <th>Description</th>
                    <th>Internship Roles</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="text-muted small">
                            {{ $categories->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="fw-bold text-dark d-flex align-items-center gap-2.5">
                                <div class="stat-icon purple" style="width:34px; height:34px; font-size:0.85rem; border-radius: 8px;">
                                    <i class="bi bi-tag-fill"></i>
                                </div>
                                <span class="fs-6">{{ $category->name }}</span>
                            </div>
                        </td>

                        <td>
                            <code class="px-2 py-1 bg-light text-primary rounded border small" style="font-size:0.75rem;">
                                {{ $category->slug }}
                            </code>
                        </td>

                        <td class="text-muted small" style="max-width: 280px;">
                            {{ $category->description ?? 'No description provided.' }}
                        </td>

                        <td>
                            <a href="{{ route('admin.internships', ['category_id' => $category->id]) }}" class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1.5 text-decoration-none">
                                <i class="bi bi-briefcase me-1"></i>
                                {{ $category->internships_count }} roles
                            </a>
                        </td>

                        <td>
                            <span class="badge-status {{ $category->is_active ? 'active' : 'inactive' }}">
                                {{ $category->is_active ? 'Active' : 'Disabled' }}
                            </span>
                        </td>

                        <td class="text-muted small">
                            {{ $category->created_at ? $category->created_at->format('M d, Y') : '—' }}
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button type="button"
                                        class="btn btn-light border"
                                        title="Edit Category"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCategoryModal{{ $category->id }}">
                                    <i class="bi bi-pencil-square text-secondary"></i>
                                </button>

                                <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-light border {{ $category->is_active ? 'text-warning' : 'text-success' }}"
                                            title="{{ $category->is_active ? 'Disable Category' : 'Enable Category' }}"
                                            onclick="return confirm('Toggle status for {{ addslashes($category->name) }}?')">
                                        <i class="bi {{ $category->is_active ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-light border text-danger"
                                            title="Delete Category"
                                            onclick="return confirm('Are you sure you want to delete category {{ addslashes($category->name) }}? Any mapped internships will become uncategorized.')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal for this category -->
                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-bottom pb-3">
                                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                        <span>Edit Category: {{ $category->name }}</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Category Title <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Description</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Brief summary of internships included in this domain...">{{ old('description', $category->description) }}</textarea>
                                        </div>

                                        <div class="form-check form-switch mt-3">
                                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="catActive{{ $category->id }}" {{ $category->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="catActive{{ $category->id }}">
                                                Active & Visible to Students
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top bg-light">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="bi bi-check-circle me-1"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-tags fs-1 text-secondary opacity-50 d-block mb-2"></i>
                            <h6 class="fw-bold mb-1">No categories configured yet</h6>
                            <p class="small text-secondary mb-3">Add domains like Software Development, Marketing, UI/UX Design, or Data Science.</p>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                <i class="bi bi-plus-circle me-1"></i> Add First Category
                            </button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($categories->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="small text-muted">
                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
            </div>
            <div>
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle-fill text-primary"></i>
                    <span>Add New Category</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Artificial Intelligence, Digital Marketing" value="{{ old('name') }}" required>
                        <div class="form-text small">A web-safe URL slug will be automatically created.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief domain scope and expectations for candidates...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" value="1" id="newCatActive" checked>
                        <label class="form-check-label fw-semibold" for="newCatActive">
                            Active & Immediately Available in Portal
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
