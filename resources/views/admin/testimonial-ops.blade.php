@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <form
            action="{{ !empty($testimonial->encrypted_id) ? route('admin.edit.testimonial', $testimonial->encrypted_id) : route('admin.add.testimonial') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Testimonial</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_testimonials') }}">All Testimonial</a></li>
                        <li class="breadcrumb-item">Create/Edit</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="{{ route('admin.manage_testimonials') }}" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            {{-- <a href="javascript:void(0);" class="btn btn-light-brand" data-bs-toggle="offcanvas"
                            data-bs-target="#proposalSent">
                            <i class="feather-layers me-2"></i>
                            <span>Save & Send</span>
                        </a> --}}
                            {{-- <a href="javascript:void(0);" class="btn btn-primary successAlertMessage">
                                <i class="feather-save me-2"></i>
                                <span>Save</span>
                            </a> --}}
                            <button type="submit" class="btn btn-primary">
                                <i class="feather-save me-2"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
             <div class="main-content">
                <div class="row">
                    <div class="col-xl-12">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <!-- Name -->
                                <div class="mb-4">
                                    <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="client_name"
                                        name="client_name"
                                        placeholder="Enter Name"
                                        value="{{ !empty($testimonial->encrypted_id) ? $testimonial->client_name : old('client_name') }}"
                                    />
                                    @error('client_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Designation -->
                                <div class="mb-4">
                                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="designation"
                                        name="designation"
                                        placeholder="Enter Designation"
                                        value="{{ !empty($testimonial->encrypted_id) ? $testimonial->client_designation : old('designation') }}"
                                    />
                                    @error('designation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Company Name -->
                                <div class="mb-4">
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="company_name"
                                        name="company_name"
                                        placeholder="Enter Company Name"
                                        value="{{ !empty($testimonial->encrypted_id) ? $testimonial->company_name : old('company_name') }}"
                                    />
                                    @error('company_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Rating (e.g., 1–5) -->
                                <div class="mb-4">
                                    <label class="form-label">Rating <span class="text-danger">*</span></label>
                                    <select
                                        class="form-select"
                                        id="rating"
                                        name="rating"
                                    >
                                        <option value="">Select Rating</option>
                                        @foreach ([1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5] as $val)
                                            <option
                                                value="{{ $val }}"
                                                {{ (!empty($testimonial->encrypted_id) ? $testimonial->rating_quantity : old('rating')) == $val ? 'selected' : '' }}
                                            >
                                                {{ $val }} Star{{ $val > 1 ? 's' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rating')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="mb-4">
                                    <label class="form-label">Image</label>
                                    @if (!empty($testimonial->encrypted_id) && !empty($testimonial->client_image))
                                        <div class="my-3">
                                            <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                                <a href="javascript:void(0)"
                                                   class="avatar-image avatar-md"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-trigger="hover"
                                                   title="{{ basename($testimonial->client_image) }}">
                                                    <img src="{{ asset($testimonial->client_image) }}" class="img-fluid" alt="Profile image"/>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <input
                                        type="file"
                                        class="form-control"
                                        name="client_image"
                                        accept="image/*"
                                    />
                            
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        rows="4"
                                        placeholder="Enter Description"
                                    >{{ !empty($testimonial->encrypted_id) ? htmlspecialchars_decode($testimonial->description) : old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Position</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="position_order"
                                            value="{{ !empty($testimonial->encrypted_id) ? $testimonial->position_order : old('position_order') }}"
                                            placeholder="Enter Order"
                                        />
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="active"
                                                {{ (!empty($testimonial->encrypted_id) ? $testimonial->status : old('status', 'active')) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ (!empty($testimonial->encrypted_id) ? $testimonial->status : old('status')) == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </form>


    </div>
@endsection

@push('page-wise-js')

@endpush 
