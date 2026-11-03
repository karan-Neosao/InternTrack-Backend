@extends('admin.layouts.app')

@section('title', 'Application #' . $application->id . ' - Details')

@section('breadcrumb')
    <li><a href="{{ route('admin.applications') }}">Applications</a></li>
    <li class="separator"><i class="bi bi-chevron-right"></i></li>
    <li class="active-item">Application #{{ $application->id }}</li>
@endsection

@section('content')

<!-- Header Banner -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.applications') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="Back to Applications">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">Application #{{ $application->id }}</h3>
                <span class="badge-status {{ strtolower($application->status) }}">
                    {{ ucfirst($application->status) }}
                </span>
            </div>
            <div class="text-secondary small">
                Submitted by <strong>{{ $application->student->name ?? 'Student' }}</strong> on {{ $application->applied_at ? \Carbon\Carbon::parse($application->applied_at)->format('F d, Y h:i A') : $application->created_at->format('F d, Y h:i A') }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex align-items-center gap-2">
        @php
            $hasResume = $application->resume_path || $application->student?->studentProfile?->resume_path;
        @endphp
        @if($hasResume)
            <a href="{{ route('admin.applications.resume', $application->id) }}" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-file-earmark-pdf"></i> Download Resume
            </a>
        @endif

        <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#deleteAppModal">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Student & Internship Details -->
    <div class="col-lg-5 col-xl-4">

        <!-- Student Summary Card -->
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="fw-bold mb-0">Student Applicant</h5>
                @if($application->student)
                    <a href="{{ route('admin.students.show', $application->student->id) }}" class="small text-primary text-decoration-none fw-semibold">
                        View Profile &rarr;
                    </a>
                @endif
            </div>

            @if($application->student)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="sidebar-user-avatar" style="width:48px; height:48px; font-size:1.125rem;">
                        {{ strtoupper(substr($application->student->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $application->student->name }}</div>
                        <div class="text-muted small">{{ $application->student->email }}</div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="text-muted small fw-semibold text-uppercase">Phone</div>
                    <div class="text-dark small">{{ $application->student->studentProfile?->phone ?? 'Not specified' }}</div>
                </div>

                <div class="mb-2">
                    <div class="text-muted small fw-semibold text-uppercase">College</div>
                    <div class="text-dark small">{{ $application->student->studentProfile?->college ?? 'Not specified' }}</div>
                </div>

                <div class="mb-2">
                    <div class="text-muted small fw-semibold text-uppercase">Course & Graduation</div>
                    <div class="text-dark small">
                        {{ $application->student->studentProfile?->course ?? 'Not specified' }}
                        @if($application->student->studentProfile?->graduation_year)
                            ({{ $application->student->studentProfile->graduation_year }})
                        @endif
                    </div>
                </div>

                @if($application->student->studentProfile?->linkedin_url)
                    <div class="mb-0 mt-3 pt-2 border-top">
                        <a href="{{ $application->student->studentProfile->linkedin_url }}" target="_blank" class="text-decoration-none text-primary small fw-semibold">
                            <i class="bi bi-linkedin me-1"></i> LinkedIn Profile &rarr;
                        </a>
                    </div>
                @endif
            @else
                <p class="text-muted small mb-0">Student record not found or has been deleted.</p>
            @endif
        </div>

        <!-- Internship Summary Card -->
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="fw-bold mb-0">Applied Internship</h5>
                @if($application->internship)
                    <a href="{{ route('admin.internships.show', $application->internship->id) }}" class="small text-primary text-decoration-none fw-semibold">
                        View Role &rarr;
                    </a>
                @endif
            </div>

            @if($application->internship)
                <div class="fw-bold text-dark fs-6 mb-1">{{ $application->internship->title }}</div>
                <div class="text-secondary small mb-3">
                    <i class="bi bi-buildings me-1"></i>
                    {{ $application->internship->company?->name ?? 'Company' }}
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <div class="text-muted small fw-semibold text-uppercase">Work Type</div>
                        <span class="badge bg-light text-dark border">{{ ucfirst($application->internship->work_type) }}</span>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small fw-semibold text-uppercase">Stipend</div>
                        <span class="fw-bold text-success">{{ $application->internship->stipend > 0 ? '$' . number_format($application->internship->stipend, 2) : 'Unpaid' }}</span>
                    </div>
                </div>

                <div class="mb-0 mt-2">
                    <div class="text-muted small fw-semibold text-uppercase">Location</div>
                    <div class="text-dark small">{{ $application->internship->location ?? 'Remote' }}</div>
                </div>
            @else
                <p class="text-muted small mb-0">Internship has been removed.</p>
            @endif
        </div>

        <!-- Resume Attachment Card -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Submitted Resume</h5>

            @if($hasResume)
                <div class="p-3 bg-light rounded-3 border d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon primary" style="width:40px; height:40px; font-size:1.1rem;">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>
                    <div class="overflow-hidden flex-grow-1">
                        <div class="fw-semibold text-truncate small">Applicant Resume</div>
                        <div class="text-muted" style="font-size:0.7rem;">PDF / Document attached</div>
                    </div>
                </div>

                <a href="{{ route('admin.applications.resume', $application->id) }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-cloud-arrow-down"></i> Download Resume File
                </a>
            @else
                <div class="text-center py-3 text-muted small">
                    <i class="bi bi-file-earmark-x fs-3 d-block mb-1 text-secondary"></i>
                    No resume document was attached.
                </div>
            @endif
        </div>

    </div>

    <!-- Right Column: Cover Letter & Status Management -->
    <div class="col-lg-7 col-xl-8">

        <!-- Status Management Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Application Decision & Status</h5>

            <form action="{{ route('admin.applications.status', $application->id) }}" method="POST" class="row g-3 align-items-center">
                @csrf
                @method('PATCH')

                <div class="col-md-7">
                    <label class="form-label fw-semibold small text-muted">CURRENT HIRING STATUS</label>
                    <select name="status" class="form-select form-select-lg" style="font-size: 0.95rem;">
                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending (Under initial queue)</option>
                        <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed (Candidate evaluated)</option>
                        <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted (Offered internship)</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected (Application declined)</option>
                    </select>
                </div>

                <div class="col-md-5 pt-md-4">
                    <button type="submit" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-check2-circle"></i> Update Application Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Cover Letter Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Applicant Cover Letter</h5>

            @if($application->cover_letter)
                <div class="p-3 bg-light rounded-3 border" style="white-space: pre-line; line-height: 1.8; color: #374151;">
                    {{ $application->cover_letter }}
                </div>
            @else
                <div class="text-muted p-4 text-center bg-light rounded-3 border">
                    <i class="bi bi-chat-left-dots fs-3 d-block mb-1 text-secondary"></i>
                    The student did not submit a cover letter with this application.
                </div>
            @endif
        </div>

        <!-- Audit & Timestamps Card -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Timeline & Audit</h5>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="text-muted small fw-semibold text-uppercase">Submission Date</div>
                    <div class="text-dark small mt-1">
                        <i class="bi bi-clock me-1 text-primary"></i>
                        {{ $application->applied_at ? \Carbon\Carbon::parse($application->applied_at)->format('d F Y, h:i A') : $application->created_at->format('d F Y, h:i A') }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-muted small fw-semibold text-uppercase">Last Status Update</div>
                    <div class="text-dark small mt-1">
                        <i class="bi bi-arrow-repeat me-1 text-secondary"></i>
                        {{ $application->updated_at->format('d F Y, h:i A') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteAppModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Application
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p>Are you sure you want to delete this application record?</p>
                <div class="alert alert-warning py-2 px-3 small border-0 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.applications.destroy', $application->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
