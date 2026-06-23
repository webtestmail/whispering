@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <form
            action="{{ !empty($subsection->encrypted_id) ? route('admin.edit.page.subsection', ['page' => $page_enc_id, 'section' => $section_enc_id, 'subsection' => $subsection->encrypted_id]) : route('admin.add.page.subsection', ['page' => $page_enc_id, 'section' => $section_enc_id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Page Sub-Section</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.edit.page.section', ['page' => $page_enc_id, 'section' => $section_enc_id]) }}">Related
                                Page Section</a>
                        </li>
                    
                        <li class="breadcrumb-item">Create/Edit</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                @if (Auth::guard('admin')->user()->role == 1)
                                    <div class="mb-4">
                                        <label for="default_section_name" class="form-label">Default Section Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="default_section_name"
                                            name="default_section_name"
                                            value="{{ !empty($subsection->encrypted_id) ? $subsection->default_section_name : old('default_section_name') }}"
                                            placeholder="Enter Default Name" />
                                        @error('default_section_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="mb-4">
                                    <label for="subsection_title" class="form-label">Sub-Section Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subsection_title" name="subsection_title"
                                        value="{{ !empty($subsection->encrypted_id) ? $subsection->section_title : old('subsection_title') }}"
                                        placeholder="Enter Title" />
                                    @error('subsection_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="subsection_headline" class="form-label">Sub-Section Headline </label>
                                    <input type="text" class="form-control" id="subsection_headline"
                                        name="subsection_headline"
                                        value="{{ !empty($subsection->encrypted_id) ? $subsection->section_headline : old('subsection_headline') }}"
                                        placeholder="Enter Headline" />
                                    @error('subsection_headline')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="section_subheading" class="form-label">Sub-Section Subheading </label>
                                    <input type="text" class="form-control" id="section_subheading" name="section_subheading"
                                        value="{{ !empty($subsection->encrypted_id) ? $subsection->section_subheading : old('section_subheading') }}"
                                        placeholder="Enter Subheading" />
                                    
                                </div>

                                 <div class="mb-4">
                                    <label for="description" class="form-label">Short Description </label>
                                    <textarea name="section_subtitle" id="section_subtitle" cols="30" rows="6" class="form-control"
                                        placeholder="Enter Short Description">{{ !empty($subsection->encrypted_id) ? htmlspecialchars_decode($subsection->section_subtitle) : old('section_subtitle') }}</textarea>
                                
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="form-label">Description </label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                        placeholder="Enter Description">{{ !empty($subsection->encrypted_id) ? htmlspecialchars_decode($subsection->description) : old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="botton" class="form-label">Button</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="button_name"
                                                name="button_name"
                                                value="{{ !empty($subsection->encrypted_id) ? $subsection->button_name : old('button_name') }}"
                                                placeholder="Enter Name" />
                                        </div>
                                       
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="button_link"
                                                name="button_link"
                                                value="{{ !empty($subsection->encrypted_id) ? $subsection->button_link : old('button_link') }}"
                                                placeholder="Enter Link" />
                                        </div>
                                        @error('button_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="subsection_image" class="form-label">Sub-Section Image</label>
                                    @if (!empty($subsection->encrypted_id) && !empty($subsection->section_image))
                                        <div class="my-3">
                                            <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                                <a href="javascript:void(0)" class="avatar-image avatar-md"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    title="{{ $subsection->section_image }}">
                                                    <img src="{{ asset($subsection->section_image) }}" class="img-fluid"
                                                        alt="image" />
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <input class="form-control" type="file" id="subsection_image"
                                        name="subsection_image" accept="image/*" />
                                    @error('subsection_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="more_images" class="form-label">Other Image </label>
                                    @if (!empty($subsection->encrypted_id) && !empty($subsection->more_images))
                                      
                                        <div class="my-3">
                                            <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                               
                                                    <a href="javascript:void(0)" class="avatar-image avatar-md"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        title="More Images">
                                                        <img src="{{ asset($subsection->more_images) }}" class="img-fluid"
                                                            alt="image" />
                                                    </a>
                                             
                                            </div>
                                        </div>
                                    @endif
                                    <input class="form-control" type="file" id="more_images" name="more_images"
                                        accept="image/*" />
                                  
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active"
                                            {{ (!empty($subsection->encrypted_id) ? $subsection->status : old('status', 'active')) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive"
                                            {{ (!empty($subsection->encrypted_id) ? $subsection->status : old('status')) == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
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
