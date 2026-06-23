@extends('admin.layouts.admin-layout')

@push('page-wise-css')
    <style>
        .logo-icon-button {
            opacity: 0 !important;
            transition: all .3s ease !important;
        }

        .logo-icon-button:hover {
            opacity: 1 !important;
            visibility: visible !important;
            transition: all .3s ease !important;
            background-color: #ecedf4 !important;
        }
    </style>
@endpush

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <form action="{{ route('admin.edit.company', $company->encrypted_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="page-header sticky-top">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Website Information</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.my-dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Manage Website Information</li>
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
                </div>
            </div>
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
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
                            <div class="card-body p-4">
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="company_icon" class="form-label">Company Icon</label>
                                            <div
                                                class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                                <img src="{{ asset($company->company_icon) }}"
                                                    class="upload-icon-pic img-fluid rounded h-100 w-100" alt="">
                                                <div class="position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer logo-icon-button"
                                                    id="icon-button">
                                                    <i class="feather feather-camera" aria-hidden="true"></i>
                                                </div>
                                                <input id="company_icon" name="company_icon" type="file"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="company_logo" class="form-label">Company Logo</label>
                                            <div
                                                class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                                <img src="{{ asset($company->company_logo) }}"
                                                    class="upload-logo-pic img-fluid rounded h-100 w-100" alt="">
                                                <div class="position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer logo-icon-button"
                                                    id="logo-button">
                                                    <i class="feather feather-camera" aria-hidden="true"></i>
                                                </div>
                                                <input id="company_logo" name="company_logo" type="file"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="company_footer_logo" class="form-label">Company Footer Logo</label>
                                            <div
                                                class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                                <img src="{{ asset($company->company_footer_logo) }}"
                                                    class="upload-footer-logo-pic img-fluid rounded h-100 w-100"
                                                    alt="">
                                                <div class="position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer logo-icon-button"
                                                    id="footer-logo-button">
                                                    <i class="feather feather-camera" aria-hidden="true"></i>
                                                </div>
                                                <input id="company_footer_logo" name="company_footer_logo" type="file"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="{{ $company->company_name }}" placeholder="Company Name">
                                        @error('company_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="get_updates_section" class="form-label">Get Updates Section (Footer)</label>
                                        <input type="text" class="form-control" id="get_updates_section" name="get_updates_section"
                                            value="{{ $company->get_updates_section }}" placeholder="Enter Content">
                                        @error('get_updates_section')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-5">
                                        <label for="copyright" class="form-label">Copy-Right</label>
                                        <textarea name="copyright" id="copyright" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Copy Right Content">{{ $company->copyright }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="footer_content_visibility" class="form-label">Footer Content
                                            Visibility</label>
                                        <select name="footer_content_visibility"
                                            onchange="change_footer_content_visibility(this.value);"
                                            id="footer_content_visibility" class="form-select form-select">
                                            <option value="no"
                                                {{ $company->footer_content_visibility == 'no' ? 'selected' : '' }}>NO
                                            </option>
                                            <option value="yes"
                                                {{ $company->footer_content_visibility == 'yes' ? 'selected' : '' }}>YES
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-5" id="footer_content_div">
                                    <label for="footer_content" class="form-label">Footer Content</label>
                                    <textarea name="footer_content" id="footer_content" cols="30" rows="5" class="form-control"
                                        placeholder="Enter Footer Content">{{ $company->footer_content }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- [ Main Content ] end -->
    </div>
@endsection

@push('page-wise-js')
    <script>
        "use strict";
        $(document).ready(function() {
            $("#company_icon").on("change", function() {
                let e, t;
                (e = this).files && e.files[0] && ((t = new FileReader).onload = function(e) {
                    $(".upload-icon-pic").attr("src", e.target.result);
                }, t.readAsDataURL(e.files[0]));
            }), $("#icon-button").on("click", function() {
                $("#company_icon").click();
            });
        });

        $(document).ready(function() {
            $("#company_logo").on("change", function() {
                let e, t;
                (e = this).files && e.files[0] && ((t = new FileReader).onload = function(e) {
                    $(".upload-logo-pic").attr("src", e.target.result);
                }, t.readAsDataURL(e.files[0]));
            }), $("#logo-button").on("click", function() {
                $("#company_logo").click();
            });
        });

        $(document).ready(function() {
            $("#company_footer_logo").on("change", function() {
                let e, t;
                (e = this).files && e.files[0] && ((t = new FileReader).onload = function(e) {
                    $(".upload-footer-logo-pic").attr("src", e.target.result);
                }, t.readAsDataURL(e.files[0]));
            }), $("#footer-logo-button").on("click", function() {
                $("#company_footer_logo").click();
            });
        });

        function change_footer_content_visibility(value) {
            if (value == "yes") {
                $("#footer_content_div").show();
            } else {
                $("#footer_content_div").hide();
            }
            return false;
        }

        change_footer_content_visibility('{{ $company->footer_content_visibility }}');
    </script>
@endpush
