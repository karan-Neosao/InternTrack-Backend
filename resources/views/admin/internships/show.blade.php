@extends('admin.layouts.app')

@section('title', $internship->title . ' - Details')

@section('breadcrumb')
    <li><a href="{{ route('admin.internships') }}">Internships</a></li>
    <li class="separator"><i class="bi bi-chevron-right"></i></li>
    <li class="active-item">{{ $internship->title }}</li>
@endsection

@section('content')

<!-- Header Banner -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.internships') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="Back to Internships">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">{{ $internship->title }}</h3>
                <span class="badge-status {{ $internship->status }}">
                    {{ ucfirst($internship->status) }}
                </span>
                <span class="badge bg-light text-secondary border">
                    {{ ucfirst($internship->work_type) }}
                </span>
            </div>
            <div class="text-secondary small">
                Posted by <strong class="text-dark">{{ $internship->company?->name ?? 'Company' }}</strong> · ID #{{ $internship->id }} · {{ $internship->created_at->format('F d, Y') }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.internships.edit', $internship->id) }}" class="btn btn-outline-primary d-flex align-items-center gap-1">
            <i class="bi bi-pencil-square"></i> Edit
        </a>

        <form action="{{ route('admin.internships.toggle-status', $internship->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-{{ $internship->status === 'active' ? 'warning' : 'success' }} d-flex align-items-center gap-1">
                <i class="bi {{ $internship->status === 'active' ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                {{ $internship->status === 'active' ? 'Close Opportunity' : 'Activate' }}
            </button>
        </form>

        <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#deleteInternshipModal">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Internship Info -->
    <div class="col-lg-5 col-xl-4">

        <!-- Overview Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Opportunity Overview</h5>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Hiring Company</div>
                <div class="fw-semibold text-dark mt-1">
                    @if($internship->company)
                        <a href="{{ route('admin.companies.show', $internship->company->id) }}" class="text-primary text-decoration-none">
                            <i class="bi bi-buildings text-primary me-2"></i>{{ $internship->company->name }} &rarr;
                        </a>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Category</div>
                <div class="fw-semibold text-dark mt-1">
                    <span class="badge bg-light text-dark border">
                        <i class="bi bi-tag text-secondary me-1"></i>
                        {{ $internship->category?->name ?? 'Uncategorized' }}
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Location & Work Type</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-geo-alt text-danger me-2"></i>
                    {{ $internship->location ?? 'Not specified' }} ({{ ucfirst($internship->work_type) }})
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Monthly Stipend</div>
                <div class="fs-5 fw-bold text-success mt-1">
                    {{ $internship->stipend > 0 ? '₹' . number_format($internship->stipend) . '/month' : 'Unpaid' }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Duration</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-clock-history text-secondary me-2"></i>
                    {{ $internship->duration ?? 'Flexible' }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Application Deadline</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-calendar-event text-warning me-2"></i>
                    {{ $internship->deadline ? $internship->deadline->format('d M Y') : 'No deadline specified' }}
                </div>
            </div>

            <div class="mb-0">
                <div class="text-muted small fw-semibold text-uppercase">Posted Date</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-calendar-check text-primary me-2"></i>{{ $internship->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        <!-- Skills Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Required Skills</h5>
            @if($internship->skills)
                @php
                    $skills = array_map('trim', explode(',', $internship->skills));
                @endphp
                <div class="d-flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        @if($skill)
                            <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
                                {{ $skill }}
                            </span>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-muted small mb-0">No specific skills listed.</p>
            @endif
        </div>

    </div>

    <!-- Right Column: Description & Applicants -->
    <div class="col-lg-7 col-xl-8">

        <!-- Role Description -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Description & Responsibilities</h5>
            <div class="text-secondary" style="white-space: pre-line; line-height: 1.7;">
                {{ $internship->description }}
            </div>
        </div>

        <!-- Applicants Table -->
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Student Applicants</h5>
                    <p class="text-muted small mb-0">List of all students who applied for this role.</p>
                </div>
                <span class="badge bg-primary px-3 py-2">
                    {{ $internship->applications->count() }} Applicants
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>College / Course</th>
                            <th>Status</th>
                            <th>Applied</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($internship->applications as $app)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="sidebar-user-avatar" style="width:34px; height:34px; font-size:0.8rem;">
                                            {{ strtoupper(substr($app->student->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.students.show', $app->student_id) }}" class="fw-bold text-dark text-decoration-none">
                                                {{ $app->student->name ?? 'N/A' }}
                                            </a>
                                            <div class="text-muted small">{{ $app->student->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-dark">{{ $app->student->studentProfile?->college ?? '—' }}</div>
                                    <div class="text-muted small">{{ $app->student->studentProfile?->course ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="badge-status {{ strtolower($app->status) }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->format('d M Y') : $app->created_at->format('d M Y') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-light border py-1 px-2" title="View Application">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-people fs-2 d-block mb-1 text-secondary"></i>
                                    No students have applied to this internship yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteInternshipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Internship
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p>Are you sure you want to permanently delete <strong>{{ $internship->title }}</strong>?</p>
                <div class="alert alert-warning py-2 px-3 small border-0 mb-0">
                    <i class="bi bi-info-circle me-1"></i> All {{ $internship->applications->count() }} submitted student applications for this opportunity will also be permanently deleted.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.internships.destroy', $internship->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
