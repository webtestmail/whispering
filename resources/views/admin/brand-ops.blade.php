@extends('admin.layouts.admin-layout')

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
    
             <form

            action="{{ !empty($memberCategory->encrypted_id ?? null) ? route($editData, $memberCategory->encrypted_id) : route($addNewData) }}"

            method="POST" enctype="multipart/form-data">

            @csrf

            <div class="page-header sticky-top">

                <div class="page-header-left d-flex align-items-center">

                    <div class="page-header-title">

                        <h5 class="m-b-10">{{$currentPageName}} Managemnt</h5>

                    </div>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>

                        <li class="breadcrumb-item"><a href="{{ route($allData) }}">All {{$currentPageName}}</a></li>

                        <li class="breadcrumb-item">Create / Modify</li>

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

     <div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary"><i class="feather-user me-2"></i>{{ $currentPageName }} Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">Name </label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $memberCategory->name ?? '') }}">
                        {{-- @error('name')
                         <span class="text-danger">{{ $message }}</span>
                         @endif --}}
                    </div>

                   <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">Brand Image <span class="text-danger">*</span></label>
                        <input type="file" name="brand_image" class="form-control" accept="image/*">
                        @if(!empty($memberCategory->brand_image))
                            <div class="mt-2">
                                <img src="{{ asset($memberCategory->brand_image) }}" 
                                    alt="Brand Image" 
                                    style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                            </div>
                        @endif
                        @error('brand_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">User Status</label>
                        <select name="is_active" class="form-select">
                            @if(!empty($memberCategory->id ?? null))
                            <option value="1" class="btn-success" {{ ($memberCategory->is_active == 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" class="btn-danger" {{ ($memberCategory->is_active == 0) ? 'selected' : '' }}>Inactive</option>
                            @else
                             <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            @endif
                        </select>
                        @error('is_active')<span>{{ $message }}</span>@enderror
                    </div>
                </div>
             
            </div>
        </div>
    </div>


</div>



            </div>
         
        </form>
    </div>
    <script>
    document.querySelectorAll('.role-check').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck all other checkboxes with the same class
                document.querySelectorAll('.role-check').forEach(other => {
                    if (other !== this) other.checked = false;
                });
            }
        });
    });

    
</script>
@endsection
