@extends('admin.layouts.admin-layout')

@php
$users = \App\Models\User::all();
$totalLeads = \App\Models\Contact::count();
$newLeads = \App\Models\Contact::where(function ($q) {
    $q->where('status', 'new')->orWhereNull('status');
})->count();
$bookingLeads = \App\Models\Contact::where('form_type', 'booking')->count();
@endphp

@section('page-content')
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10" style="border-right:none !important;">Dashboard</h5>
                </div>
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
                        <!-- <div id="reportrange" class="reportrange-picker d-flex align-items-center">
                            <span class="reportrange-picker-field"></span>
                        </div> -->
                        <div class="dropdown filter-dropdown">
                            <a class="btn btn-md btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10"
                                data-bs-auto-close="outside">
                                <i class="feather-filter me-2"></i>
                                <span>Filter</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Role"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Role">Role</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Team"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Team">Team</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Email"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Email">Email</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Member"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer" for="Member">Member</label>
                                    </div>
                                </div>
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="Recommendation"
                                            checked="checked" />
                                        <label class="custom-control-label c-pointer"
                                            for="Recommendation">Recommendation</label>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="feather-plus me-3"></i>
                                    <span>Create New</span>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="feather-filter me-3"></i>
                                    <span>Manage Filter</span>
                                </a>
                            </div>
                        </div>
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
                <!-- [Invoices Awaiting Payment] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-users"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $users->count() }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Users
                                            </h3>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </div>
                            <div class="pt-4 d-none">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);"
                                        class="fs-12 fw-medium text-muted text-truncate-1-line">Total Membership Purchased
                                    </a>
                                    <div class="w-100 text-end">
                                        <span class="fs-12 text-dark">$5,569</span>
                                        <span class="fs-11 text-muted">(56%)</span>
                                    </div>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 56%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Invoices Awaiting Payment] end -->
                <!-- [Total Leads] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-mail"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $totalLeads }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Leads</h3>
                                    </div>
                                </div>
                                <a href="{{ route('admin.manage_contact_form') }}" class="">
                                    <i class="feather-external-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Total Leads] end -->
                <!-- [New Leads] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-inbox"></i>
                                    </div>
                                    <div>
                                    
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $newLeads }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">New Leads</h3>
                                    </div>
                                </div>
                                <a href="{{ route('admin.manage_contact_form') }}" class="">
                                    <i class="feather-external-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [New Leads] end -->
                <!-- [Booking Enquiries] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-calendar"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">{{ $bookingLeads }}</span></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Booking Enquiries
                                        </h3>
                                    </div>
                                </div>
                                <a href="{{ route('admin.manage_contact_form') }}" class="">
                                    <i class="feather-external-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Booking Enquiries] end -->
                <!-- [Conversion Rate] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-activity"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><span class="counter">0</span>
                                        </div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">New Leads</h3>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" class="">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </div>
                            <div class="pt-4 d-none">
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">
                                        Conversion Rate
                                    </a>
                                    <div class="w-100 text-end">
                                        <span class="fs-12 text-dark">$2,254</span>
                                        <span class="fs-11 text-muted">(46%)</span>
                                    </div>
                                </div>
                                <div class="progress mt-2 ht-3">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 46%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Conversion Rate] end -->
                <!-- [Payment Records] start -->
                <div class="col-xxl-8">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Registeration Pipeline</h5>
                            <div class="card-header-action">
                                <div class="card-header-btn">
                                    <div data-bs-toggle="tooltip" title="Delete">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger"
                                            data-bs-toggle="remove"> </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Refresh">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning"
                                            data-bs-toggle="refresh"> </a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                            data-bs-toggle="expand"> </a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown"
                                        data-bs-offset="25, 25">
                                        <div data-bs-toggle="tooltip" title="Options">
                                            <i class="feather-more-vertical"></i>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-at-sign"></i>New</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-calendar"></i>Event</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-bell"></i>Snoozed</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-trash-2"></i>Deleted</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-settings"></i>Settings</a>
                                        <a href="javascript:void(0);" class="dropdown-item"><i
                                                class="feather-life-buoy"></i>Tips & Tricks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body custom-card-action p-0">
                            <div id="payment-records-chart"></div>
                        </div>
                        <div class="card-footer">
                            <div class="row g-4">
                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Approved applications</div>
                                        <h6 class="fw-bold text-dark"></h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 81%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Pending applications</div>
                                        <h6 class="fw-bold text-dark"></h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 82%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Rejected applications</div>
                                        <h6 class="fw-bold text-dark"></h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 82%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
      

             
  
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
