@extends('admin.layouts.app')

@section('title', ($company->companyProfile?->company_name ?? $company->name) . ' - Company Profile')

@section('breadcrumb')
    <li><a href="{{ route('admin.companies') }}">Companies</a></li>
    <li class="separator"><i class="bi bi-chevron-right"></i></li>
    <li class="active-item">{{ $company->companyProfile?->company_name ?? $company->name }}</li>
@endsection

@section('content')

<!-- Header Banner -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.companies') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="Back to Companies">
            <i class="bi bi-arrow-left"></i>
        </a>

        @if($company->companyProfile?->logo_path)
            <img src="{{ asset('storage/' . $company->companyProfile->logo_path) }}"
                 alt="{{ $company->name }}"
                 class="rounded-3 border object-fit-cover shadow-sm"
                 style="width: 56px; height: 56px;">
        @else
            <div class="stat-icon teal" style="width: 56px; height: 56px; font-size: 1.5rem; border-radius: 12px;">
                <i class="bi bi-buildings"></i>
            </div>
        @endif

        <div>
            <div class="d-flex align-items-center gap-2">
                <h3 class="fw-bold mb-0" style="letter-spacing:-0.5px;">
                    {{ $company->companyProfile?->company_name ?? $company->name }}
                </h3>
                @if($company->companyProfile?->is_verified)
                    <span class="badge-status verified"><i class="bi bi-patch-check-fill me-1"></i>Verified</span>
                @else
                    <span class="badge-status pending">Unverified</span>
                @endif
                <span class="badge-status {{ $company->is_active ? 'active' : 'inactive' }}">
                    {{ $company->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="text-secondary small">
                Company ID: #{{ $company->id }} · Registered {{ $company->created_at->format('F d, Y') }}
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('admin.companies.toggle-verify', $company->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-{{ $company->companyProfile?->is_verified ? 'secondary' : 'success' }} d-flex align-items-center gap-1">
                <i class="bi {{ $company->companyProfile?->is_verified ? 'bi-patch-minus' : 'bi-patch-check' }}"></i>
                {{ $company->companyProfile?->is_verified ? 'Unverify Company' : 'Verify Company' }}
            </button>
        </form>

        <form action="{{ route('admin.companies.toggle-status', $company->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-{{ $company->is_active ? 'warning' : 'success' }} d-flex align-items-center gap-1">
                <i class="bi {{ $company->is_active ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                {{ $company->is_active ? 'Deactivate' : 'Activate' }}
            </button>
        </form>

        <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#deleteCompanyModal">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
</div>

<div class="row g-4">

    <!-- Left Column: Details & Stats -->
    <div class="col-lg-5 col-xl-4">

        <!-- Stats Overview -->
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="card p-3 text-center">
                    <div class="fs-3 fw-bold text-primary">{{ $company->internships->count() }}</div>
                    <div class="text-muted small fw-semibold text-uppercase">Internships</div>
                </div>
            </div>
            <div class="col-6">
                <div class="card p-3 text-center">
                    <div class="fs-3 fw-bold text-success">{{ $totalApplications }}</div>
                    <div class="text-muted small fw-semibold text-uppercase">Applicants</div>
                </div>
            </div>
        </div>

        <!-- Company Overview Card -->
        <div class="card p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Company Overview</h5>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Contact Email</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-envelope text-primary me-2"></i>{{ $company->email }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Official Website</div>
                <div class="mt-1">
                    @if($company->companyProfile?->website)
                        <a href="{{ $company->companyProfile->website }}" target="_blank" class="text-decoration-none text-primary fw-semibold">
                            <i class="bi bi-globe me-1"></i> {{ $company->companyProfile->website }} &rarr;
                        </a>
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Industry / Domain</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-briefcase text-secondary me-2"></i>
                    {{ $company->companyProfile?->industry ?? 'Not specified' }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted small fw-semibold text-uppercase">Headquarters / Location</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-geo-alt text-danger me-2"></i>
                    {{ $company->companyProfile?->location ?? 'Not specified' }}
                </div>
            </div>

            <div class="mb-0">
                <div class="text-muted small fw-semibold text-uppercase">Registration Date</div>
                <div class="fw-semibold text-dark mt-1">
                    <i class="bi bi-calendar3 text-primary me-2"></i>{{ $company->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        <!-- About Description -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">About Organization</h5>
            <p class="text-secondary mb-0" style="white-space: pre-line;">
                {{ $company->companyProfile?->description ?: 'No company description provided.' }}
            </p>
        </div>

    </div>

    <!-- Right Column: Posted Internships -->
    <div class="col-lg-7 col-xl-8">

        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Posted Internships</h5>
                    <p class="text-muted small mb-0">All opportunities published by {{ $company->name }}.</p>
                </div>
                <a href="{{ route('admin.internships.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                    <i class="bi bi-plus-circle"></i> Post New Internship
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Work Type</th>
                            <th>Stipend</th>
                            <th>Deadline</th>
                            <th>Applicants</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($company->internships as $internship)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.internships.show', $internship->id) }}" class="fw-bold text-dark text-decoration-none">
                                        {{ $internship->title }}
                                    </a>
                                    <div class="text-muted small">{{ $internship->location ?? 'Remote' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        {{ ucfirst($internship->work_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">
                                        {{ $internship->stipend > 0 ? '₹' . number_format($internship->stipend) . '/mo' : 'Unpaid' }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $internship->deadline ? $internship->deadline->format('d M Y') : 'Open' }}
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                        {{ $internship->applications_count }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status {{ $internship->status }}">
                                        {{ ucfirst($internship->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.internships.show', $internship->id) }}" class="btn btn-sm btn-light border py-1 px-2" title="View Internship">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-briefcase fs-2 d-block mb-2 text-secondary"></i>
                                    <div class="fw-bold">No Internships Posted</div>
                                    <p class="small text-muted mb-0">This company has not listed any internships yet.</p>
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
<div class="modal fade" id="deleteCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Company
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <p>Are you sure you want to permanently delete <strong>{{ $company->name }}</strong>?</p>
                <div class="alert alert-warning py-2 px-3 small border-0 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This will delete the company account, logo, and all {{ $company->internships->count() }} posted internships along with applicant submissions.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete Company</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
