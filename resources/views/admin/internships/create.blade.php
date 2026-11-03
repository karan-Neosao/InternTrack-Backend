@extends('admin.layouts.app')

@section('title', 'Post New Internship')

@section('breadcrumb')
    <li><a href="{{ route('admin.internships') }}">Internships</a></li>
    <li class="separator"><i class="bi bi-chevron-right"></i></li>
    <li class="active-item">Create</li>
@endsection

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.internships') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-2">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h3 class="fw-bold mb-1" style="letter-spacing:-0.5px;">Create New Internship</h3>
        <p class="text-secondary mb-0">Publish an internship opening for a partner company.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-7">
        <div class="card p-4">
            <form action="{{ route('admin.internships.store') }}" method="POST">
                @csrf

                <!-- Company Selection -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Hiring Company <span class="text-danger">*</span></label>
                    <select name="company_id" class="form-select @error('company_id') is-invalid @enderror" required>
                        <option value="">Select Company...</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }} ({{ $company->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Internship Category</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Select Category (Optional)...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Internship Title <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="e.g. Full Stack Developer Intern"
                        value="{{ old('title') }}"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <!-- Work Type -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Work Type <span class="text-danger">*</span></label>
                        <select name="work_type" class="form-select @error('work_type') is-invalid @enderror" required>
                            <option value="onsite" {{ old('work_type') === 'onsite' ? 'selected' : '' }}>Onsite</option>
                            <option value="remote" {{ old('work_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                            <option value="hybrid" {{ old('work_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('work_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Location</label>
                        <input
                            type="text"
                            name="location"
                            class="form-control @error('location') is-invalid @enderror"
                            placeholder="e.g. New York, NY / Remote"
                            value="{{ old('location') }}"
                        >
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Stipend -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Monthly Stipend ($)</label>
                        <input
                            type="number"
                            step="0.01"
                            name="stipend"
                            class="form-control @error('stipend') is-invalid @enderror"
                            placeholder="0.00"
                            value="{{ old('stipend', '0') }}"
                        >
                        @error('stipend')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Duration</label>
                        <input
                            type="text"
                            name="duration"
                            class="form-control @error('duration') is-invalid @enderror"
                            placeholder="e.g. 3 Months"
                            value="{{ old('duration') }}"
                        >
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deadline -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Application Deadline</label>
                        <input
                            type="date"
                            name="deadline"
                            class="form-control @error('deadline') is-invalid @enderror"
                            value="{{ old('deadline') }}"
                        >
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Initial Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active (Visible & Open for applications)</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed (Archived / Not accepting)</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Skills -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Required Skills</label>
                    <input
                        type="text"
                        name="skills"
                        class="form-control @error('skills') is-invalid @enderror"
                        placeholder="e.g. PHP, Laravel, MySQL, Flutter, Git"
                        value="{{ old('skills') }}"
                    >
                    <div class="form-text small text-muted">Separate skills with commas.</div>
                    @error('skills')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Description & Responsibilities <span class="text-danger">*</span></label>
                    <textarea
                        name="description"
                        rows="6"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Provide details about the role, responsibilities, prerequisites, and what the intern will learn..."
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-1"></i> Publish Internship
                    </button>
                    <a href="{{ route('admin.internships') }}" class="btn btn-light border px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
