@extends('admin.layouts.admin-layout')


@push('page-wise-css')
<style>
    .custom-dropdown {
    position: relative;
    width: 100%;
}

.dropdown-header {
    padding: 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    background: #fff;
}

.dropdown-body {
    display: none; /* 🔥 THIS IS WHY YOURS IS ALWAYS OPEN */
    position: absolute;
    width: 100%;
    border: 1px solid #ccc;
    background: #fff;
    max-height: 200px;
    overflow-y: auto;
    z-index: 999;
}
</style>

@endpush
@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <form
            action="{{ !empty($section->encrypted_id) ? route('admin.edit.page.section', ['page' => $page_enc_id, 'section' => $section->encrypted_id]) : route('admin.add.page.section', $page_enc_id) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Page Section</h5>
                    </div>
                    
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.edit.page', $page_enc_id) }}">Related Page</a>
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
                                <input type="hidden" name="page_id" value="{{ !empty($section->encrypted_id) ? $section->encrypted_id : ''}}" id="page_id">
                                  <input type="hidden" name="section_id" value="{{ !empty($page_enc_id) ? $page_enc_id : ''}}" id="section_id">
                                @if (Auth::guard('admin')->user()->role == 1)
                                    <div class="mb-4">
                                        <label for="default_section_name" class="form-label">Default Section Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="default_section_name"
                                            name="default_section_name"
                                            value="{{ !empty($section->encrypted_id) ? $section->default_section_name : old('default_section_name') }}"
                                            placeholder="Enter Default Name" />
                                        @error('default_section_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="mb-4">
                                    <label for="section_title" class="form-label">Section Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="section_title" name="section_title"
                                        value="{{ !empty($section->encrypted_id) ? $section->section_title : old('section_title') }}"
                                        placeholder="Enter Title" />
                                    @error('section_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="section_headline" class="form-label">Section Headline </label>
                                    <input type="text" class="form-control" id="section_headline" name="section_headline"
                                        value="{{ !empty($section->encrypted_id) ? $section->section_headline : old('section_headline') }}"
                                        placeholder="Enter Headline" />
                                    @error('section_headline')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                        placeholder="Enter Description">{{ !empty($section->encrypted_id) ? htmlspecialchars_decode($section->description) : old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="video_link" class="form-label">Video Link </label>
                                    <input type="text" class="form-control" id="video_link" name="video_link"
                                        value="{{ !empty($section->encrypted_id) ? $section->video_link : old('video_link') }}"
                                        placeholder="Enter Video Link" />
                                   
                                </div>
                                
                                @if(!empty($section->encrypted_id) && $section->id == 102)
                            
                            <div class="mb-4">
                                <label class="form-label">Select FAQs</label>
                            
                                <div class="custom-dropdown">
                                    <div class="dropdown-header" onclick="toggleDropdown(this)">
                                        Select FAQs
                                    </div>
                                  @php
                                    $faqs = resolve(App\Http\Controllers\Admin\FaqsController::class)->getAllFaqs();
                                @endphp
                                    <div class="dropdown-body">
                                        @foreach($faqs as $id => $question)
                                            <label class="dropdown-item">
                                                <input type="checkbox" name="faq_ids[]" value="{{ $question->id }}"
                                                    {{ (is_array(old('faq_ids')) && in_array($question->id, old('faq_ids'))) 
                                                        || (!empty($section->faq_id) && in_array($question->id, json_decode($section->faq_id, true))) 
                                                        ? 'checked' : '' }}>
                                                {{ $question->question }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            @endif
                  
                  
                  @if(!empty($section->encrypted_id) && $section->id == 113)
                                              <div class="mb-4">
                                <label class="form-label">Select FAQs</label>
                            
                                <div class="custom-dropdown">
                                    <div class="dropdown-header" onclick="toggleDropdown(this)">
                                        Select FAQs
                                    </div>
                                  @php
                                    $faqs = resolve(App\Http\Controllers\Admin\FaqsController::class)->getdashboardFaqs();
                                @endphp
                                    <div class="dropdown-body">
                                        @foreach($faqs as $id => $question)
                                            <label class="dropdown-item">
                                                <input type="checkbox" name="faq_ids[]" value="{{ $question->id }}"
                                                    {{ (is_array(old('faq_ids')) && in_array($question->id, old('faq_ids'))) 
                                                        || (!empty($section->faq_id) && in_array($question->id, json_decode($section->faq_id, true))) 
                                                        ? 'checked' : '' }}>
                                                {{ $question->question }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                  @endif
                                <div class="mb-4">
                                    <label for="botton" class="form-label">Button </label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="button_name" name="button_name"
                                                value="{{ !empty($section->encrypted_id) ? $section->button_name : old('button_name') }}"
                                                placeholder="Enter Name" />
                                        </div>
                                        @error('button_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="button_link"
                                                name="button_link"
                                                value="{{ !empty($section->encrypted_id) ? $section->button_link : old('button_link') }}"
                                                placeholder="Enter Title" />
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
                                    <label for="section_image" class="form-label">Section Image / Video</label>
                                    @if (!empty($section->encrypted_id) && !empty($section->section_image))
                                        <div class="my-3">
                                            <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                                <a href="javascript:void(0)" class="avatar-image avatar-md"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    title="{{ $section->section_image }}">
                                                    <img src="{{ asset($section->section_image) }}" class="img-fluid"
                                                        alt="image" />
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <input class="form-control" type="file" id="section_image" name="section_image"
                                        accept="image/*" />
                                    @error('section_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="more_images" class="form-label">More Images </label>
                                    @if (!empty($section->encrypted_id) && !empty($section->more_images))
                                        @php
                                            $more_images = json_decode($section->more_images) ?? [];
                                        @endphp
                                        <div class="my-3">
                                            <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                                @foreach ($more_images as $image)
                                                    <a href="javascript:void(0)" class="avatar-image avatar-md"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        title="More Images">
                                                        <img src="{{ asset($image) }}" class="img-fluid"
                                                            alt="image" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    <input class="form-control" type="file" id="more_images" name="more_images[]"
                                        accept="image/*" multiple />
                                    @error('more_images')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                 <div class="mb-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active"
                                            {{ (!empty($section->encrypted_id) ? $section->status : old('status', 'active')) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive"
                                            {{ (!empty($section->encrypted_id) ? $section->status : old('status')) == 'inactive' ? 'selected' : '' }}>
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

        @if (!empty($section->encrypted_id))
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Page Sub-Sections</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Manage Page Sub-Sections</li>
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
                            @if (Auth::guard('admin')->user()->role == 1)
                                <a href="{{ route('admin.add.page.subsection', ['page' => $page_enc_id, 'section' => $section->encrypted_id]) }}"
                                    class="btn btn-primary">
                                    <i class="feather-plus me-2"></i>
                                    <span>New Page Sub-Section</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="pagesubsection_table">
                                        <thead>
                                            <tr>
                                                {{-- <th class="wd-30">
                                                    <div class="btn-group mb-1">
                                                        <div class="custom-control custom-checkbox ms-1">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="checkAllProposal">
                                                            <label class="custom-control-label"
                                                                for="checkAllProposal"></label>
                                                        </div>
                                                    </div>
                                                </th> --}}
                                                <th>S. No.</th>
                                                <th>Sub-Section Title</th>
                                                <th>Sub-Section Headline</th>
                                                <th>Sub-Section Position</th>
                                                <th>Sub-Section Image</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

      <script>
    $(document).ready(function () {
        new DataTable('#pagesubsection_table', {
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            order: [[8, "desc"]],
            info: true,
            lengthChange: true,
            pageLength: 10,
            ajax: {
                url: '{{ route("admin.pagesubsection.data") }}',
                type: 'GET',
                data: function (d) {
                    d.page_id = $('#page_id').val();
                    d.section_id = $('#section_id').val(); // send encrypted page_id
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'section_title', name: 'section_title' },
                { data: 'section_headline', name: 'section_headline' },
                { data: 'position_order', name: 'position_order' },
                { data: 'section_image', name: 'section_image' },
                { data: 'is_active', name: 'is_active' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.dropdown-header').forEach(header => {
        header.addEventListener('click', function (e) {
            e.stopPropagation();

            let dropdown = this.parentElement;

            // close others
            document.querySelectorAll('.dropdown-body').forEach(body => {
                if (body !== dropdown.querySelector('.dropdown-body')) {
                    body.style.display = 'none';
                }
            });

            let body = dropdown.querySelector('.dropdown-body');
            body.style.display = body.style.display === 'block' ? 'none' : 'block';
        });
    });

    // ✅ PREVENT closing when clicking inside dropdown
    document.querySelectorAll('.dropdown-body').forEach(body => {
        body.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

    // close only when clicking outside
    document.addEventListener('click', function () {
        document.querySelectorAll('.dropdown-body').forEach(body => {
            body.style.display = 'none';
        });
    });

});
</script>
@endsection

