@extends('admin.layouts.app')

@section('title', $student->name . ' - Student Profile')

@section('breadcrumb')
    <li><a href="{{ route('admin.students') }}">Students</a></li>
    <li class="separator"><i class="bi bi-chevron-right"></i></li>
    <li class="active-item">{{ $student->name }}</li>
@endsection

@section('content')

<!-- Header Banner -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="Back to Students">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="sidebar-user-avatar" style="width: 52px; height: 52px; font-size: 1.25rem;">
            {{ strtoupper(substr($student->name, 0, 1)) }}
        </div>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">{{ $student->name }}</h3>
                <span class="badge-status {{ $student->is_active ? 'active' : 'inactive' }}">
                    {{ $student->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="text-secondary small">
                Student ID: #{{ $student->id }} · Member since {{ $student->created_at->format('F d, Y') }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('admin.students.toggle-status', $student->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-{{ $student->is_active ? 'warning' : 'success' }} d-flex align-items-center gap-1">
                <i class="bi {{ $student->is_active ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                {{ $student->is_active ? 'Deactivate Account' : 'Activate Account' }}
            </button>
        </form>

        <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#deleteStudentModal">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Student Details -->
    <div class="col-lg-5 col-xl-4">

        <!-- Personal & Contact Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Contact & Overview</h5>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Email Address</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-envelope text-primary me-2"></i>{{ $student->email }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Phone Number</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-telephone text-primary me-2"></i>
                    {{ $student->studentProfile?->phone ?? 'Not provided' }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">LinkedIn Profile</div>
                <div class="mt-1">
                    @if($student->studentProfile?->linkedin_url)
                        <a href="{{ $student->studentProfile->linkedin_url }}" target="_blank" class="text-decoration-none text-primary fw-semibold">
                            <i class="bi bi-linkedin text-primary me-1"></i> View LinkedIn Profile &rarr;
                        </a>
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>
            </div>

            <div class="mb-0">
                <div class="text-muted small fw-semibold text-uppercase">Account Registered</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-calendar3 text-primary me-2"></i>{{ $student->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        <!-- Academic Details Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Academic Background</h5>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">College / University</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-buildings text-secondary me-2"></i>
                    {{ $student->studentProfile?->college ?? 'Not specified' }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Course / Degree</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-book text-secondary me-2"></i>
                    {{ $student->studentProfile?->course ?? 'Not specified' }}
                </div>
            </div>

            <div class="mb-0">
                <div class="text-muted small fw-semibold text-uppercase">Graduation Year</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-mortarboard text-secondary me-2"></i>
                    {{ $student->studentProfile?->graduation_year ?? 'Not specified' }}
                </div>
            </div>
        </div>

        <!-- Resume Card -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Resume / CV</h5>

            @if($student->studentProfile?->resume_path)
                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3 border">
                    <div class="stat-icon primary" style="width:40px; height:40px; font-size:1.1rem;">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>
                    <div class="overflow-hidden flex-grow-1">
                        <div class="fw-semibold text-truncate small">{{ basename($student->studentProfile->resume_path) }}</div>
                        <div class="text-muted" style="font-size:0.7rem;">Document on file</div>
                    </div>
                </div>

                <a href="{{ route('admin.students.resume', $student->id) }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-cloud-arrow-down"></i> Download Resume
                </a>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-file-earmark-x fs-2 d-block mb-1 text-secondary"></i>
                    <div class="small">No resume uploaded by student.</div>
                </div>
            @endif
        </div>

    </div>

    <!-- Right Column: Skills & Application History -->
    <div class="col-lg-7 col-xl-8">

        <!-- Skills Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Technical & Soft Skills</h5>

            @if($student->studentProfile?->skills)
                @php
                    $skills = array_map('trim', explode(',', $student->studentProfile->skills));
                @endphp
                <div class="d-flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        @if($skill)
                            <span class="badge bg-light text-dark border px-3 py-2 fw-semibold" style="font-size:0.8125rem;">
                                {{ $skill }}
                            </span>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-0">No skills listed in student profile.</p>
            @endif
        </div>

        <!-- Application History -->
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Submitted Applications</h5>
                    <p class="text-muted small mb-0">History of all internship applications submitted by this student.</p>
                </div>
                <span class="badge bg-primary px-3 py-2">
                    {{ $student->applications->count() }} Total
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Internship</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->applications as $app)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $app->internship?->title ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ ucfirst($app->internship?->work_type ?? '') }}</div>
                                </td>
                                <td>
                                    <span class="text-secondary fw-medium">{{ $app->internship?->company?->name ?? 'N/A' }}</span>
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
                                    <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                    This student has not applied for any internships yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p>Are you sure you want to permanently delete <strong>{{ $student->name }}</strong>?</p>
                <div class="alert alert-warning py-2 px-3 small border-0 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This action cannot be undone. All related profile records and submitted applications will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
