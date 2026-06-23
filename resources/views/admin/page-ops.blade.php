@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <form
            action="{{ !empty($page->encrypted_id) ? route('admin.edit.page', $page->encrypted_id) : route('admin.add.page') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Page</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_pages') }}">All Pages</a></li>
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
                                <input type="hidden" name="page_id" value="{{ !empty($page->encrypted_id) ? $page->encrypted_id : ''}}" id="page_id">
                                @if (Auth::guard('admin')->user()->role == 1)
                                    <div class="mb-4">
                                        <label for="client_page_link" class="form-label">Client Page Link <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="client_page_link"
                                            name="client_page_link"
                                            value="{{ !empty($page->encrypted_id) ? $page->client_page_urls : old('client_page_link') }}"
                                            placeholder="Enter Link" />
                                        @error('client_page_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="mb-4">
                                    <label for="page_name" class="form-label">Page Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="page_name" name="page_name"
                                        value="{{ !empty($page->encrypted_id) ? $page->page_name : old('page_name') }}"
                                        placeholder="Enter Name" />
                                    @error('page_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="header_footer_name" class="form-label">Name in Header & Footer <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="header_footer_name"
                                        name="header_footer_name"
                                        value="{{ !empty($page->encrypted_id) ? $page->header_footer_name : old('header_footer_name') }}"
                                        placeholder="Enter Name for Header & Footer" />
                                    @error('header_footer_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="page_headline" class="form-label">Page Headline <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="page_headline" name="page_headline"
                                        value="{{ !empty($page->encrypted_id) ? $page->page_headline : old('page_headline') }}"
                                        placeholder="Enter Headline" />
                                    @error('page_headline')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="breadcrumb_headline" class="form-label">Breadcrumb Headline <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="breadcrumb_headline"
                                        name="breadcrumb_headline"
                                        value="{{ !empty($page->encrypted_id) ? $page->breadcrumb_headline : old('breadcrumb_headline') }}"
                                        placeholder="Enter Breadcrumb Headline" />
                                    @error('breadcrumb_headline')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="breadcrumb_description" class="form-label">Breadcrumb Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="breadcrumb_description" id="breadcrumb_description" cols="30" rows="10"
                                        class="form-control" placeholder="Enter Breadcrumb Description">{{ !empty($page->encrypted_id) ? htmlspecialchars_decode($page->breadcrumb_description) : old('breadcrumb_description') }}</textarea>
                                    @error('breadcrumb_description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                        placeholder="Enter Description">{{ !empty($page->encrypted_id) ? htmlspecialchars_decode($page->description) : old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                              @if(isset($page) && !empty($page->encrypted_id) && ($page->id == 6 || $page->id == 24))
                                  <div class="mb-4">
                                    <label for="description" class="form-label">Video Link</label>
                                    <input type="text" name="video_link" class="form-control"
                                        placeholder="Enter Video Link" value="{{ !empty($page->encrypted_id) ? ($page->video_link) : old('video_link') }}">
                                 
                                </div>
                                @endif

                                     <div class="mb-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active"
                                            {{ (!empty($page->encrypted_id) ? $page->status : old('status', 'active')) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive"
                                            {{ (!empty($page->encrypted_id) ? $page->status : old('status')) == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="meta_title" class="form-label">Meta Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ !empty($page->encrypted_id) ? $page->meta_title : old('meta_title') }}"
                                        placeholder="Enter Title" />
                                    @error('meta_title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="meta_keyword" class="form-label">Meta Keyword <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                        value="{{ !empty($page->encrypted_id) ? $page->meta_keyword : old('meta_keyword') }}"
                                        placeholder="Enter Keywords" />
                                    @error('meta_keyword')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="meta_description" class="form-label">Meta Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="10" class="form-control"
                                        placeholder="Enter Meta Description">{{ !empty($page->encrypted_id) ? htmlspecialchars_decode($page->meta_description) : old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="page_image" class="form-label">Breadcrumb Image <span
                                            class="text-danger">*</span></label>
                                    @if (!empty($page->encrypted_id) && !empty($page->page_image))
                                        <div class="my-3">
                                            <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">
                                                    @php
                                                        $ext = pathinfo($page->page_image, PATHINFO_EXTENSION);
                                                        $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'ogg']);
                                                    @endphp
                                                  @if ($isVideo)
                                                        <!-- Show video thumbnail -->
                                                        <a href="javascript:void(0)"
                                                        class="avatar-image avatar-md"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover"
                                                        title="{{ $page->page_image }}">
                                                            <video class="img-fluid" controls>
                                                                <source src="{{ asset($page->page_image) }}" type="video/{{ $ext }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </a>
                                                    @else
                                                        <!-- Show image -->
                                                        <a href="javascript:void(0)"
                                                        class="avatar-image avatar-md"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover"
                                                        title="{{ $page->page_image }}">
                                                            <img src="{{ asset($page->page_image) }}" class="img-fluid" alt="image" />
                                                        </a>
                                                    @endif
                                            </div>
                                        </div>
                                    @endif
                                    <input class="form-control" type="file" id="page_image" name="page_image"
                                        accept="image/*" />
                                    @error('page_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </form>

        @if (!empty($page->encrypted_id))
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Page Sections</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Manage Page Sections</li>
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
                                <a href="{{ route('admin.add.page.section', $page->encrypted_id) }}"
                                    class="btn btn-primary">
                                    <i class="feather-plus me-2"></i>
                                    <span>New Page Section</span>
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
                                <table class="table table-hover" id="pagesection_table">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>SECTION TITLE</th>
                                            <th>SECTION HEADLINE </th>
                                            <th>SECTION POSITION </th>
                                            <th>SECTION IMAGE </th>
                                            <th>MORE IMAGES </th>
                                            <th>STATUS</th>
                                            <th class="text-end">ACTION</th>
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
        new DataTable('#pagesection_table', {
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            order: [[8, "desc"]],
            info: true,
            lengthChange: true,
            pageLength: 10,
            ajax: {
                url: '{{ route("admin.pagesection.data") }}',
                type: 'GET',
                data: function (d) {
                    d.page_id = $('#page_id').val(); // send encrypted page_id
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'section_title', name: 'section_title' },
                { data: 'section_headline', name: 'section_headline' },
                { data: 'position_order', name: 'position_order' },
                { data: 'section_image', name: 'section_image' },
                { data: 'more_images', name: 'more_images' },
                { data: 'is_active', name: 'is_active' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
